<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 08.12.2018
 * Time: 17:49
 */

namespace controller;

use services\RoleServiceImpl;
use services\AuthServiceImpl;

class RoleController
{
    public static function create() {
        (new RoleServiceImpl())->createAdminRole();
        AuthServiceImpl::getInstance()->elevate($_GET["id"]);

    }


}