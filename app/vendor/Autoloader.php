<?php


class Autoloader{

    static function autoload($className){
        include 'at_app/vendor/'.$className.'.php';
    }

    static function registre(){
        spl_autoload_register(array(__CLASS__,'autoload'));
    }

}
?>