<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 05.12.2018
 * Time: 21:05
 */

namespace dao;


use domain\Spot;

class SpotDAO extends BasicDAO
{
    public function create(Spot $spot) {
        $stmt = $this->pdoInstance->prepare('
      INSERT INTO spot (lat, lng, name, address, category, scomment, userid)
        SELECT :lat, :lng, :name, :address, :category, :scomment, :userid
    ');
        $stmt->bindValue(':lat', $spot->getLat());
        $stmt->bindValue(':lng', $spot->getLng());
        $stmt->bindValue(':name', $spot->getName());
        $stmt->bindValue(':address', $spot->getAddress());
        $stmt->bindValue(':category', $spot->getCategory());
        $stmt->bindValue(':scomment', $spot->getScomment());
        $stmt->bindValue(':userid', $spot->getUserid());
        $stmt->execute();
        return $this->read($this->pdoInstance->lastInsertId());
    }

    public function read($spotId) {
        $stmt = $this->pdoInstance->prepare('
        SELECT spot.id, lat, lng, name, address, category, userid, username FROM spot INNER JOIN customer ON customer.id = spot.userid WHERE spot.id = :id;;
        ');
        $stmt->bindValue(':id', $spotId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Spot")[0];
        }
        return null;
    }

    public function update(Spot $spot) {
        $stmt = $this->pdoInstance->prepare('
         UPDATE spot SET name = :name,
            address = :address,
            lat = :lat,
            lng = :lng,
            category = :category,
            scomment = :scomment
        WHERE id =:id');
        $stmt->bindValue(':name', $spot->getName());
        $stmt->bindValue(':address', $spot->getAddress());
        $stmt->bindValue(':lat', $spot->getLat());
        $stmt->bindValue(':lng', $spot->getLng());
        $stmt->bindValue(':category', $spot->getCategory());
        $stmt->bindValue(':scomment', $spot->getScomment());
        $stmt->bindValue(':id', $spot->getId());
        $stmt->execute();
        return $this->read($spot->getId());
    }

    public function delete(Spot $spot) {
        $stmt = $this->pdoInstance->prepare('
            DELETE FROM spot
            WHERE id = :id
        ');
        $stmt->bindValue(':id', $spot->getId());
        $stmt->execute();
    }

    public function listAllSpots() {
        $stmt = $this->pdoInstance->prepare('
        SELECT spot.id, lat, lng, name, address, category, userid, username FROM spot INNER JOIN customer ON customer.id = spot.userid ORDER BY id DESC;
        ');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Spot");
    }

    public function findByCustomer($userId) {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM spot WHERE userid = :userId ORDER BY userid;');
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Spot");
    }

}