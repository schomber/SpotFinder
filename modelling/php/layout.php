<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:15
 */

function layoutSetContent($content){
    require_once("header.php");
    require_once($content);
    require_once("footer.php");
}