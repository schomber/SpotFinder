<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 15.11.2018
 * Time: 23:29
 */

namespace config;


class Autoloader
{
    public static function autoload($className){
        //replace namespace backslash to directory separator of the current operating system
        $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
        $fileName = $className . '.php';

        if (file_exists($fileName)) {
            include_once($fileName);
        } else {
            return false;
        }
    }
}

spl_autoload_register('config\Autoloader::autoload');