<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 10.12.2018
 * Time: 01:37
 */

namespace services;

use dao\RoleDAO;
class RoleServiceImpl
{
    public function createAdminRole(){
        $roleDAO = new RoleDAO();
        if($this->checkAdminRoleCreated()){
            $roleDAO->createAdminRole();
        }
    }

    public function checkAdminRoleCreated() {
        $roleDAO = new RoleDAO();
        if(count($roleDAO->listAll())<1){
            return true;
        }
        return false;
    }


}