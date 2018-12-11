<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 10.12.2018
 * Time: 15:00
 */

namespace controller;

use view\TemplateView;
use services\AuthServiceImpl;
use services\EmailServiceClient;

class CustomerPasswordResetController
{
    public static function resetView(){
        $resetView = new TemplateView("customerPasswordReset.php");
        $resetView->token = $_GET["token"];
        echo $resetView->render();
    }

    public static function requestView(){
        echo (new TemplateView("customerPasswordResetRequest.php"))->render();
    }

    public static function reset(){
        if(AuthServiceImpl::getInstance()->validateToken($_POST["token"])){
            $customer = AuthServiceImpl::getInstance()->readCustomer(AuthServiceImpl::getInstance()->getCurrentCustomerId());
            $customer->setPassword($_POST["password"]);
            echo "ich will spielen";
            if(AuthServiceImpl::getInstance()->editCustomer($customer->getId(), $customer->getUsername(),$customer->getFirstname(),$customer->getSurname(),$customer->getEmail(),$customer->getPassword())){
                    return true;
            }
            $customer->setPassword("");
            $resetView = new TemplateView("customerPasswordReset.php");
            $resetView->token = $_POST["token"];
            echo $resetView->render();
            return false;
        }
        return false;
    }

    public static function resetEmail(){
        $token = AuthServiceImpl::getInstance()->issueToken(AuthServiceImpl::RESET_TOKEN, $_POST["email"]);
        $emailView = new TemplateView("customerPasswordResetEmail.php");
        $emailView->resetLink = $GLOBALS["ROOT_URL"] . "/password/reset?token=" . $token;
        return EmailServiceClient::sendEmail($_POST["email"], "Password Reset Email", $emailView->render());
    }
}