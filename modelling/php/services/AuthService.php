<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 08.12.2018
 * Time: 23:56
 */

namespace services;

use domain\Customer;

interface AuthService{

    const CUST_TOKEN = 1;

    const RESET_TOKEN = 2;

    public function verfiyCustomer($email, $password);

    public function readCustomer($id);

    public function editCustomer($id,$username, $firstname, $surname, $email ,$password);

    public function validateToken($token);

    public function issueToken($type = self::CUST_TOKEN, $email = null);

}