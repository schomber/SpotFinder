<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 09.12.2018
 * Time: 00:02
 */

namespace services;

use domain\Customer;
use dao\CustomerDAO;
use http\HTTPException;
use http\HTTPStatusCode;

class AuthServiceImpl implements AuthService
{
    private static $instance = null;

    private $currentCustomerId;

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function __construct() {}

    private function __clone() { }

    public function verifyAuth() {
        if(isset($this->currentCustomerId))
            return true;
        return false;
    }

    /**
     * @return mixed
     */
    public function getCurrentCustomerId()
    {
        return $this->currentCustomerId;
    }



    public function verfiyCustomer($email, $password)
    {
        $customerDAO = new CustomerDAO();
        $customer = $customerDAO->findByEmail($email);
        if (isset($customer)) {
            if (password_verify($password, $customer->getPassword())) {
                if(password_needs_rehash($customer->getPassword(), PASSWORD_DEFAULT)) {
                    $customer->setPassword(password_hash($password, PASSWORD_DEFAULT));
                    $customerDAO->update($customer);
                }
                $this->currentCustomerId = $customer->getId();
                return true;
            }
        }
        return false;
    }

    public function readCustomer()
    {
        if($this->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            return $customerDAO->read($this->currentCustomerId);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    public function editCustomer($username, $firstname,$surname, $email, $password)
    {
        $customer = new Customer();
        $customer->setUsername($username);
        $customer->setFirstname($firstname);
        $customer->setSurname($surname);
        $customer->setEmail($email);
        $customer->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $customerDAO = new CustomerDAO();
        if($this->verifyAuth()) {
            $customer->setId($this->currentCustomerId);
            if($customerDAO->read($this->currentCustomerId)->getEmail() !== $customer->getEmail()) {
                if(!is_null($customerDAO->findByEmail($email))) {
                    return false;
                }
            } $customerDAO->update($customer);
                return true;
        } else {
            if(!is_null($customerDAO->findByEmail($email))) {
                return false;
            }
            $customerDAO->create($customer);
            return true;
        }
    }

    public function validateToken($token) {
        $tokenArray = explode(":", $token);
        if(count($tokenArray)>1) {
            $this->currentCustomerId = $tokenArray[0];
            return true;
        }
        return false;
    }

    public function issueToken($type = self::CUST_TOKEN, $email = null){
        return $this->currentCustomerId . ":" . bin2hex(random_bytes(20));
    }
}