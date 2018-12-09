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
        $view->customer = AuthServiceImpl::getInstance()->readCustomer();
        LayoutRendering::basicLayout($view);
    }

    //TODO implement amdin Priv so all users can be edited
    public static function adminEdit(){
        $id = $_GET["id"];
        $contentView = new TemplateView("editUser.php");
        $contentView->customer = (new CustomerDAO())->read($id);
        LayoutRendering::basicLayout($contentView);
    }

    //TODO implement amdin Priv so all users can be edited
    public static function adminDelete(){
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
        $contentView->customers = (new CustomerDAO())->listAll();
        LayoutRendering::basicLayout($contentView);
    }

    public static function update(){
        AuthServiceImpl::getInstance()->editCustomer($_POST["username"], $_POST["firstname"],$_POST["surname"],$_POST["email"], $_POST["password"]);
        /*
        $customerDAO = new CustomerDAO();
        $customer = new Customer();

        $id = $_POST["id"];
        if ($id === "") {
            $customer->setUsername($_POST['username']);
            $customer->setFirstname($_POST['firstname']);
            $customer->setSurname($_POST["surname"]);
            $customer->setEmail($_POST["email"]);
            $customer->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT));
            $customerDAO->create($customer);
        } else {
            $customer->setId($id);
            $customer->setFirstname($_POST['firstname']);
            $customer->setSurname($_POST["surname"]);
            $customer->setEmail($_POST["email"]);
            $customerDAO->update($customer);
        }*/
    }

    public static function register() {
        AuthServiceImpl::getInstance()->editCustomer($_POST["firstname"], $_POST["firstname"],$_POST["surname"],$_POST["email"], $_POST["password"]);
        /* $customer = new Customer();
        $customer->setUsername($_POST['username']);
        $customer->setFirstname($_POST['firstname']);
        $customer->setSurname($_POST["surname"]);
        $customer->setEmail($_POST["email"]);
        $customer->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT));
        $customerDAO = new CustomerDAO();
        $customerDAO->create($customer);*/
    }

    public static function registerView(){
        echo (new TemplateView("register.php"))->render();
    }

    public static function loginView(){
        echo (new TemplateView("login.php"))->render();
    }

}