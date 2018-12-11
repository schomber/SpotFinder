<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 08.12.2018
 * Time: 16:58
 */

namespace controller;

use dao\CustomerDAO;
use services\AuthServiceImpl;
use view\LayoutRendering;
use view\TemplateView;
use domain\Customer;

class CustomerController
{
    public static function edit(){
        $view = new TemplateView("editUser.php");
        $view->customer = AuthServiceImpl::getInstance()->readCustomer($_GET['id']);
        LayoutRendering::basicLayout($view);
    }

    //TODO implement amdin Priv so all users can be edited
    public static function delete(){
        $id = $_GET["id"];
        $customerDAO = new CustomerDAO();
        $customer = new Customer();
        $customer->setId($id);
        if($_SESSION["userLogin"]["id"] != $id) {
            $customerDAO->delete($customer);
        }
    }

    //TODO implement amdin Priv so all users can be edited
    public static function readAll(){
        $contentView = new TemplateView("userList.php");
        $contentView->customers = AuthServiceImpl::getInstance()->listAllUser();
        LayoutRendering::basicLayout($contentView);
    }

    public static function update(){
        AuthServiceImpl::getInstance()->editCustomer($_POST['id'],$_POST["username"], $_POST["firstname"],$_POST["surname"],$_POST["email"], $_POST["password"]);
    }

    public static function register() {
        AuthServiceImpl::getInstance()->editCustomer($_POST['id'],$_POST["username"], $_POST["firstname"],$_POST["surname"],$_POST["email"], $_POST["password"]);

    }

    public static function registerView(){
        echo (new TemplateView("register.php"))->render();
    }

    public static function loginView(){
        echo (new TemplateView("login.php"))->render();
    }

}