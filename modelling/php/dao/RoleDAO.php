<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 05.12.2018
 * Time: 21:05
 */

namespace dao;

use domain\Role;

class RoleDAO extends BasicDAO
{
    public function createAdminRole() {
        $stmt = $this->pdoInstance->prepare('
      INSERT INTO role (role)
        SELECT :role
    ');
        $stmt->bindValue(':role', "test");
        $stmt->execute();
    }

    public function listAll() {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM role ORDER BY id;');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Role");
    }


}