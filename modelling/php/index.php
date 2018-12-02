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

Router::route("POST", "/register", function () {
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $pdoInstance = Database::connect();
    $stmt = $pdoInstance->prepare('
      INSERT INTO customer (uUsername, uFName, uSName, sEmail, sPassword)
        SELECT :uUsername, :uFName, :uSName, :sEmail, :sPassword
        WHERE NOT EXISTS (
          SELECT sEmail FROM customer WHERE sEmail = :emailExist
        );
    ');
    $stmt->bindValue(':uUsername', $username);
    $stmt->bindValue(':uFName', $firstname);
    $stmt->bindValue(':uSName', $surname);
    $stmt->bindValue(':sEmail', $email);
    $stmt->bindValue(':emailExist', $email);
    $stmt->bindValue(':sPassword', password_hash($_POST["password"], PASSWORD_DEFAULT));
    $stmt->execute();

    Router::redirect("/logout");
});


Router::route("POST", "/login", function () {
    $email = $_POST["email"];
    $pdoInstance = Database::connect();
    $stml = $pdoInstance->prepare('
        SELECT * FROM customer WHERE semail = :email;');
    $stml->bindValue(':email', $email);
    $stml->execute();
    if($stml->rowCount()>0) {
        $customer = $stml->fetchAll(PDO::FETCH_ASSOC)[0];
        if(password_verify($_POST["password"], $customer["spassword"])) {
            session_regenerate_id(true);
            $_SESSION["userLogin"]["username"] = $customer["uusername"];
            $_SESSION["userLogin"]["email"] = $email;
            $_SESSION["userLogin"]["firstname"] =$customer["ufname"];
            $_SESSION["userLogin"]["surname"] =$customer["usname"];
            $_SESSION["userLogin"]["id"] = $customer["uid"];
            if(password_needs_rehash($customer["spassword"], PASSWORD_DEFAULT)){
                $stml = $pdoInstance->prepare('
                UPDATE customer SET spassword=:password WHERE uid =:id;');
                $stml->bindValue(':id', $customer["uid"]);
                $stml->bindValue(':password', password_hash(($_POST["password"]),PASSWORD_DEFAULT));
                $stml->execute();

            }
        }
    }
    Router::redirect("/");
});



Router::route_auth("GET", "/", $authFunction, function () {
    $pdoInstance = Database::connect();
    $stmt = $pdoInstance->prepare('
        SELECT * FROM customer ORDER BY uid;');
   // $stmt->bindValue(':uid', $_SESSION["userLogin"]["id"]);
    $stmt->execute();
    global $customers;
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    layoutSetContent("userList.php");
});


Router::route_auth("GET", "/userList", $authFunction, function (){
    Router::redirect("/");
});

Router::route_auth("GET", "/user/delete", $authFunction, function (){
    $id = $_GET["id"];
    $pdoInstance = Database::connect();
    $stmt = $pdoInstance->prepare('
        DELETE FROM customer
            WHERE uid = :id
    ');
    $stmt->bindValue(':id', $id);
    if($_SESSION["userLogin"]["id"] != $id) {
        $stmt->execute();
    }
    Router::redirect("/");
});

Router::route_auth("GET", "/user/edit", $authFunction, function (){
    $id = $_GET["id"];
    $pdoInstance = Database::connect();
    $stmt = $pdoInstance->prepare(' 
       SELECT * FROM customer WHERE uid = :id;');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    global $customer;
    $customer = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

    layoutSetContent("editUser.php");

});

Router::route_auth("POST", "/user/update", $authFunction, function (){
    $id = $_POST["id"];
    $username = $_POST["username"];
    $firstname = $_POST["firstname"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];

    if ($id === "") {
        $pdoInstance = Database::connect();
        $stmt = $pdoInstance->prepare('
            INSERT INTO customer (uUsername, uFName, uSName, sEmail)
            VALUES (:uUsername, :uFName , :uSName, :sEmail)');
        $stmt->bindValue(':uUsername', $username);
        $stmt->bindValue(':uFName', $firstname);
        $stmt->bindValue(':uSName', $surname);
        $stmt->bindValue(':sEmail', $email);
        $stmt->execute();
    } else {
        $pdoInstance = Database::connect();
        $stmt = $pdoInstance->prepare('
            UPDATE customer SET ufname = :uFName,
                usname = :uSName,
                semail = :sEmail
            WHERE uid =:id');
        $stmt->bindValue(':uFName', "test");
        $stmt->bindValue(':uSName', $surname);
        $stmt->bindValue(':sEmail', $email);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }
    Router::redirect("/");

});


Router::route_auth("GET", "/addSpot", $authFunction, function (){
    layoutSetContent("addSpot.php");
});

Router::route_auth("GET", "/editUser", $authFunction, function (){
    layoutSetContent("editUser.php");
});

Router::route_auth("GET", "/editSpot", $authFunction, function (){
    layoutSetContent("editSpot.php");
});

Router::route_auth("GET", "/spotList", $authFunction, function (){
    layoutSetContent("spotList.php");
});

Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $errorFunction);