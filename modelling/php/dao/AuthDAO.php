<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 10.12.2018
 * Time: 13:23
 */

namespace dao;

use domain\AuthToken;

class AuthDAO extends BasicDAO
{
    public function create(AuthToken $authToken){
        $stmt = $this->pdoInstance->prepare('
            INSERT INTO authtoken (selector, validator, expiration, atype, userid)
              VALUES (:selector, :validator, :expiration, :atype, :userid);
        ');
        $stmt->bindValue(':selector', $authToken->getSelector());
        $stmt->bindValue(':validator', $authToken->getValidator());
        $stmt->bindValue(':expiration', $authToken->getExpiration());
        $stmt->bindValue(':atype', $authToken->getAtype());
        $stmt->bindValue(':userid', $authToken->getUserid());
        $stmt->execute();
        return $this->findBySelector($authToken->getSelector());

    }

    public function delete(AuthToken $authToken) {
        $stmt = $this->pdoInstance->prepare('
            DELETE FROM authtoken
            WHERE id = :id
        ');
        $stmt->bindValue(':id', $authToken->getId());
        $stmt->execute();
    }

    public function findBySelector($selector) {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM authtoken WHERE selector = :selector;');
        $stmt->bindValue(':selector', $selector);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\AuthToken")[0];
        }
        return null;
    }
}