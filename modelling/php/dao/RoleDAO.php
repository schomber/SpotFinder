<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 05.12.2018
 * Time: 21:05
 */

namespace dao;

use domain\Role;

class RoleDAO
{
    public function createAdminRole(Role $role) {
        $stmt = $this->pdoInstance->prepare('
      INSERT INTO role (role)
        SELECT :role
    ');
        $stmt->bindValue(':role', $role->getRole());
        $stmt->execute();
        return $this->read($this->pdoInstance->lastInsertId());
    }

}