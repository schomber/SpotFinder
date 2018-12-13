<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 08.12.2018
 * Time: 19:26
 */

namespace controller;

use view\TemplateView;

class ErrorController
{
    public static function show404(){
        echo (new TemplateView("404.php"))->render();
    }
}