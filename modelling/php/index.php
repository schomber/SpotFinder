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
    session_regenerate_id(true);
    $_SESSION['agentLogin']=$_POST['email'];
    Router::redirect("/");
});

Router::route("GET", "/logout", function () {
    session_destroy();
    Router::redirect("/login");
});

Router::route_auth("GET", "/", $authFunction, function () {
    layoutSetContent("register.php");
});


Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $errorFunction);