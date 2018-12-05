<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 05.12.2018
 * Time: 19:28
 */

namespace dao;

use domain\Customer;


class CustomerDAO extends BasicDAO
{
    public function create(Customer $customer)
    {
        $stmt = $this->pdoInstance->prepare('
      INSERT INTO customer (username, firstname, surname, email, password)
        SELECT :username, :firstname, :surname, :email, :password
        WHERE NOT EXISTS (
          SELECT email FROM customer WHERE email = :emailExist
        );
    ');
        $stmt->bindValue(':username', $customer->getUsername());
        $stmt->bindValue(':firstname', $customer->getFirstname());
        $stmt->bindValue(':surname', $customer->getSurname());
        $stmt->bindValue(':email', $customer->getEmail());
        $stmt->bindValue(':emailExist', $customer->getEmail());
        $stmt->bindValue(':password', $customer->getPassword());
        $stmt->execute();
        return $this->read($this->pdoInstance->lastInsertId());
    }

    public function read($customerId)
    {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM customer WHERE id = :id;');
        $stmt->bindValue(':id', $customerId);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Customer")[0];
        }
        return null;
    }

    public function update(Customer $customer)
    {
        $stmt = $this->pdoInstance->prepare('
                UPDATE customer SET username=:username, firstname=:firstname, surname=:surname, email=:email WHERE id = :id;');
        $stmt->bindValue(':id', $customer->getId());
        $stmt->bindValue(':firstname', $customer->getFirstname());
        $stmt->bindValue(':surname', $customer->getSurname());
        $stmt->bindValue(':email', $customer->getEmail());
        $stmt->execute();
        return $this->read($customer->getId());
    }

    //TODO poosible to implement Role as well -> for checking if user is elevated to do so
    public function delete(Customer $customer) {
        $stmt = $this->pdoInstance->prepare('
            DELETE FROM customer
            WHERE id = :id
        ');
        $stmt->bindValue(':id', $customer->getId());
        $stmt->execute();
    }

    public function listAll() {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM customer ORDER BY id;');
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Customer");
    }

    public function findByEmail($email) {
        $stmt = $this->pdoInstance->prepare('
            SELECT * FROM customer WHERE email = :email;');
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        if ($stmt->rowCount() > 0)
            return $stmt->fetchAll(\PDO::FETCH_CLASS, "domain\Customer")[0];
        return null;
    }

    //Elevate Customer == Admin Role
    public function elevate(Customer $customer)
    {
        $stmt = $this->pdoInstance->prepare('
                UPDATE customer SET roleid=:roleid WHERE id = :id;');
        $stmt->bindValue(':id', $customer->getId());
        $stmt->bindValue(':roleid', $customer->getRoleid());
        $stmt->execute();
        return $this->read($customer->getId());
    }

    //TODO add if needed some additional search logic for customers
}