<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:11
 */

require_once("view/layout.php");
require_once("config/Autoloader.php");

use router\Router;
use database\Database;
use http\HTTPException;
use domain\Customer;
use domain\Spot;
use domain\Role;
use dao\CustomerDAO;
use dao\SpotDAO;
use dao\RoleDAO;

session_start();

$authFunction = function () {
    if (isset($_SESSION["userLogin"])) {
        return true;
    }
    Router::redirect("/login");
    return false;
};

$errorFunction = function () {
    Router::errorHeader();
    require_once("view/404.php");
};

Router::route("GET", "/login", function () {
    require_once("view/login.php");
});

Router::route("GET", "/register", function () {
    require_once("view/register.php");
});

Router::route("GET", "/logout", function () {
    session_destroy();
    Router::redirect("/login");
});

Router::route_auth("GET", "/", $authFunction, function () {
    $customerDAO = new CustomerDAO();
    global $customers;
    $customers = $customerDAO->listAll();
    layoutSetContent("userList.php");
});

Router::route("POST", "/register", function () {
    $customer = new Customer();
    $customer->setUsername($_POST['username']);
    $customer->setFirstname($_POST['firstname']);
    $customer->setSurname($_POST["surname"]);
    $customer->setEmail($_POST["email"]);
    $customer->setPassword(password_hash($_POST["password"], PASSWORD_DEFAULT));
    $customerDAO = new CustomerDAO();
    $customerDAO->create($customer);
    Router::redirect("/logout");
});

Router::route("POST", "/login", function () {
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
    Router::redirect("/");
});

Router::route_auth("GET", "/userList", $authFunction, function (){
    Router::redirect("/");
});

Router::route_auth("GET", "/user/delete", $authFunction, function (){
    $id = $_GET["id"];
    $customerDAO = new CustomerDAO();
    $customer = new Customer();
    $customer->setId($id);
    if($_SESSION["userLogin"]["id"] != $id) {
        $customerDAO->delete($customer);
    }
    Router::redirect("/");
});

Router::route_auth("GET", "/user/edit", $authFunction, function (){
    $id = $_GET["id"];
    $customerDAO = new CustomerDAO();
    global $customer;
    $customer = $customerDAO->read($id);
    layoutSetContent("editUser.php");
});

Router::route_auth("POST", "/user/update", $authFunction, function (){
    $id = $_POST["id"];
    echo $id;
    $customerDAO = new CustomerDAO();
    $customer = new Customer();

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
    }
    Router::redirect("/");
});

Router::route("POST", "/addSpot", function () {
    $spotDAO = new SpotDAO();
    $spot = new Spot();
    $spot->setName($_POST["name"]);
    $spot->setLat($_POST["latitude"]);
    $spot->setLng($_POST["longitude"]);
    $spot->setAddress($_POST["address"]);
    $spot->setCategory($_POST["category"]);
    $spot->setComment($_POST["comment"]);
    $spot->setUserid($_SESSION["userLogin"]["id"]);
    $spotDAO->create($spot);
    Router::redirect("/spotList");
});


Router::route_auth("GET", "/addSpot", $authFunction, function (){
    layoutSetContent("addSpot.php");
});

Router::route_auth("GET", "/spot/edit", $authFunction, function (){
    $id = $_GET["id"];
    $spotDAO = new SpotDAO();
    global $spot;
    $spot = $spotDAO->read($id);
    layoutSetContent("editSpot.php");
});

//TODO implement check if user is allowed to do this
Router::route_auth("GET", "/spot/delete", $authFunction, function (){
    $id = $_GET["id"];
    $spotDAO = new SpotDAO();
    $spot = new Spot();
    $spot->setId($id);
    $spotDAO->delete($spot);
    Router::redirect("/spotList");
});

Router::route_auth("POST", "/spot/update", $authFunction, function (){
    $spotDAO = new SpotDAO();
    $spot = new Spot();
    $spot->setId($_POST["id"]);
    $spot->setName($_POST["name"]);
    $spot->setAddress($_POST["address"]);
    $spot->setLat($_POST["latitude"]);
    $spot->setLng($_POST["longitude"]);
    $spot->setCategory($_POST["category"]);
    $spot->setComment($_POST["comment"]);
    $spotDAO->update($spot);
    Router::redirect("/spotList");
});

//TODO Role implementation that only elevated users or creator are able to edit or delete
Router::route_auth("GET", "/spotList", $authFunction, function (){
    $spotDAO = new SpotDAO();
    global $spots;
    $spots = $spotDAO->listAllSpots();
    layoutSetContent("spotList.php");
});

try {
    Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
} catch (HTTPException $exception) {
    $exception->getHeader();
    require_once("view/404.php");
}