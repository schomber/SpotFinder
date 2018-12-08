<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 08.12.2018
 * Time: 17:17
 */

namespace controller;

use dao\CustomerDAO;
use domain\Customer;

class AuthController
{
    public static function authenticate(){
        if (isset($_SESSION["userLogin"])) {
            return true;
        }
        return false;
    }

    public static function login(){
        $email = $_POST["email"];
        $customerDAO = new CustomerDAO();
        $customer = $customerDAO->findByEmail($email);
        if (isset($customer)) {
            if (password_verify($_POST["password"], $customer->getPassword())) {
                session_regenerate_id(true);
                $_SESSION["userLogin"]["username"] = $customer->getUsername();
                $_SESSION["userLogin"]["email"] = $customer->getEmail();
                $_SESSION["userLogin"]["firstname"] = $customer->getFirstname();
                $_SESSION["userLogin"]["surname"] =$customer->getSurname();
                $_SESSION["userLogin"]["id"] = $customer->getId();
                if (password_needs_rehash($customer->getPassword(), PASSWORD_DEFAULT)) {
                    $customer->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT));
                    $customerDAO->update($customer);
                }
            }
        }
    }
}