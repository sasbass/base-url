<?php
class Url {
    
    const DATE_FORMAT = "Y-d-m H:i:s";
    
    private function __construct(){}
    
    private static function getURI(){
        return explode('/', $_SERVER['REQUEST_URI']);
    }
    
    private static function getName(){
        return explode('/',$_SERVER['SCRIPT_NAME']);
    }
    
    /**
     * This method takes the data from the
     * url address and returns an array
     * with: url http://localhost/folder-project/controler/method/params/.../...
     * @return array
     */
    private static function splitUrl(){
        $scriptName = self::getName();
        $requestURI = self::getURI();
        
        $str_lenght = sizeof($scriptName);
        if($str_lenght==0) return;
        
        for($i= 0;$i < $str_lenght;$i++) {            
            if ($requestURI[$i] == $scriptName[$i]){
                unset($requestURI[$i]);
            }
        }
        
        // Remove empty value
        $requestURI = array_filter($requestURI);
        return array_values($requestURI);
    }
    
    /**
     * Build base url whether you use a domain name or a direct path to the folder.
     * Supported HTTP and HTTPS
     * @return string
     */
    public static function Base_URL(){
        if (isset($_SERVER['HTTP_HOST'])){
            $base_url = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
            $base_url .= '://'. $_SERVER['HTTP_HOST'];
            $base_url .= str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        } else {
            $base_url = 'http://localhost/';
        }
        return $base_url;
    }

    /**
     * Get first parameter
     * @return string
     */
    public static function Controller(){
        $result = self::splitUrl();
        if(isset($result[0])) return $result[0];
    }
    
    /**
     * Get second parameter
     * @return string
     */
    public static function Method(){
        $result = self::splitUrl();
        return $result[1];
    }
    
    /**
     * Get all parameters
     * @return array
     */
    public static function Params(){
        $result = self::splitUrl();
        $result = array_slice($result, 1);
        return $result;
    }
    
    /**
     * For last three symbols.
     * If you need get domain extension.
     * @return string
     */
    public static function getDomainEx(){
        $domain = str_replace('/', '', self::Base_URL());
        return substr($domain, -3);
    }
    
    /**
     * Generate log file.
     * @param string $text - Here post your text message.
     * @param string $file_name - If you need other fine name.
     * @param string $file_path - If you like use other path.
     * @param string $type - Using default "FILE_APPEND".
     * 
     * Description(FILE_APPEND): If file filename already exists, 
     * append the data to the file instead
     * of overwriting it. 
     * Or visit it: http://php.net/manual/en/function.file-put-contents.php 
     */
    final public static function wLog($text, $file_name='debug.txt', $file_path='', $type = FILE_APPEND){
        \file_put_contents($file_path . $file_name, \date(self::DATE_FORMAT)." : ".$text."\n",$type);
    }
}