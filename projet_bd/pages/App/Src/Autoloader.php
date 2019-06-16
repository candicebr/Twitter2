<?php
namespace App\Src;

class Autoloader
{
    /**
     * Met en place les différents autoloader de l'App php
     */
    public static function register()
    {
        spl_autoload_register(array(__CLASS__, 'autoload'));
    }

    public static function autoload($class){
        $nameSpace = explode('\\', $class);
        $class = implode('/', $nameSpace);
        require_once $_SERVER['DOCUMENT_ROOT'] . '/' . $class.'.php';
    }
}