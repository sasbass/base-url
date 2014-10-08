<?php
include_once 'url.php';

trait GlobTraits {
    function BaseUrl(){
        return url::Base_URL();
    }
    
    function autoLoad($filename){
        if(file_exists($filename. '.php')) {
            require 'page/' . $filename . '.php';
        }
        return false;
    }
}

class DemoClass {
    use GlobTraits;
}

$get_root_path = __DIR__;
$d = new DemoClass();

echo 'The base url: ' .$d->BaseUrl(). "<br/>";

$controler_name = url::Controller();
if(!empty($controler_name)){
   $d->autoLoad($controler_name);
}

