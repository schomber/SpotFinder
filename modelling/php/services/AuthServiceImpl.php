<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 09.12.2018
 * Time: 00:02
 */

namespace services;

use dao\AuthDAO;
use domain\AuthToken;
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

    /**
     * Customer AREA
     */

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

    public function readCustomer($id)
    {
        if($this->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            if(($this->getCurrentCustomerId() == $customerDAO->read($id)->getId()) || $this->verfiyAdmin()){
                return $customerDAO->read($id);
            }
            throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    public function editCustomer($id,$username, $firstname,$surname, $email, $password)
    {
        $customer = new Customer();
        $customer->setId($id);
        $customer->setUsername($username);
        $customer->setFirstname($firstname);
        $customer->setSurname($surname);
        $customer->setEmail($email);
        $customer->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $customerDAO = new CustomerDAO();
        if($this->verifyAuth()) {
            if(($customerDAO->read($this->currentCustomerId)->getId() == $customer->getId()) || $this->verfiyAdmin()) {
                $customerDAO->update($customer);
                return true;
            }
            else {
                if(!is_null($customerDAO->findByEmail($email))) {
                    return false;
                }
            }

        } else {
            if(!is_null($customerDAO->findByEmail($email))) {
                return false;
            }
            $customerDAO->create($customer);
            return true;
        }
    }

    public function listAllUser(){
        $customerDAO = new CustomerDAO();
        if ($this->verifyAuth() && $this->verfiyAdmin()){
            return $customerDAO->listAll();
        }
        return null;
    }

    public function elevate($id){
        if($this->verifyAuth()){
            $customer = new Customer();
            $customer->setId($id);
            $customerDAO = new CustomerDAO();
            if(((is_null($customerDAO->read($id)->getRoleid()) && $this->verifyAdminExists()) || $this->verfiyAdmin())) {
                $customerDAO->elevate($customer);
            }
        }
    }

    /**
     * ADMIN AREA
     */

    public function verfiyAdmin()
    {
        if ($this->verifyAuth()) {
            $customerDAO = new CustomerDAO();
            if ($customerDAO->read($this->getCurrentCustomerId())->getRoleid() == 1) {
                return true;
            }
        }
        return false;
    }

    public function verifyAdminExists(){
        $customerDAO = new CustomerDAO();
        foreach ($customerDAO->listAll() as $customer) {
            if(!is_null($customer->getRoleid())) {
                return false;
            }
            return true;
        }
    }

    /**
     * AUTH TOKEN AREA
     */
    //TODO check pw reset ... still not as should work
    public function validateToken($token) {
        $tokenArray = explode(":", $token);
        $authTokenDAO = new AuthDAO();
        $authToken = $authTokenDAO->findBySelector($tokenArray[0]);
        if (!empty($authToken)) {
            if(time()<=(new \DateTime($authToken->getExpiration()))->getTimestamp()) {
                if(hash_equals(hash('sha384', hex2bin($tokenArray[1])), $authToken->getValidator())) {
                    $this->currentCustomerId = $authToken->getUserid();
                    if($authToken->getAtype()===self::RESET_TOKEN){
                        $authTokenDAO->delete($authToken);
                    }
                    return true;
                }
            }
            $authTokenDAO->delete($authToken);
        }
        return false;
    }

    public function issueToken($type = self::CUST_TOKEN, $email = null){
        $token = new AuthToken();
        $token->setSelector(bin2hex(random_bytes(5)));
        if($type===self::CUST_TOKEN) {
            $token->setAtype(self::CUST_TOKEN);
            $token->setUserid($this->currentCustomerId);
            $timestamp = (new \DateTime('now'))->modify('+30 days');
        } elseif (isset($email)) {
            $token->setAtype(self::RESET_TOKEN);
            $token->setUserid((new CustomerDAO())->findByEmail($email)->getId());
            $timestamp = (new \DateTime('now'))->modify('+1 hour');
        } else {
            throw new HTTPException(HTTPStatusCode::HTTP_406_NOT_ACCEPTABLE);
        }



        $token->setExpiration($timestamp->format("Y-m-d H:1:s"));
        $validator = random_bytes(20);
        $token->setValidator(hash('sha384', $validator));
        $authTokenDAO = new AuthDAO();
        $authTokenDAO->create($token);
        return $token->getSelector() .":". bin2hex($validator);
    }
}