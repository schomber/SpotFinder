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
      INSERT INTO customer (username, firstname, surname, email, password)
        SELECT :username, :firstname, :surname, :email, :password
        WHERE NOT EXISTS (
          SELECT email FROM customer WHERE email = :emailExist
        );
    ');
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':firstname', $firstname);
    $stmt->bindValue(':surname', $surname);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':emailExist', $email);
    $stmt->bindValue(':password', password_hash($_POST["password"], PASSWORD_DEFAULT));
    $stmt->execute();

    Router::redirect("/logout");
});


Router::route("POST", "/login", function () {
    $email = $_POST["email"];
    $pdoInstance = Database::connect();
    $stml = $pdoInstance->prepare('
        SELECT * FROM customer WHERE email = :email;');
    $stml->bindValue(':email', $email);
    $stml->execute();
    if($stml->rowCount()>0) {
        $customer = $stml->fetchAll(PDO::FETCH_ASSOC)[0];
        if(password_verify($_POST["password"], $customer["password"])) {
            session_regenerate_id(true);
            $_SESSION["userLogin"]["username"] = $customer["username"];
            $_SESSION["userLogin"]["email"] = $email;
            $_SESSION["userLogin"]["firstname"] =$customer["firstname"];
            $_SESSION["userLogin"]["surname"] =$customer["surname"];
            $_SESSION["userLogin"]["id"] = $customer["id"];
            if(password_needs_rehash($customer["password"], PASSWORD_DEFAULT)){
                $stml = $pdoInstance->prepare('
                UPDATE customer SET password=:password WHERE id =:id;');
                $stml->bindValue(':id', $customer["id"]);
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
        SELECT * FROM customer ORDER BY id;');
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
            WHERE id = :id
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
       SELECT * FROM customer WHERE id = :id;');
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
            INSERT INTO customer (username, firstname, surname, email)
            VALUES (:username, :firstname , :surname, :email)');
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':firstname', $firstname);
        $stmt->bindValue(':surname', $surname);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
    } else {
        $pdoInstance = Database::connect();
        $stmt = $pdoInstance->prepare('
            UPDATE customer SET firstname = :firstname,
                username = :username,
                email = :email
            WHERE id =:id');
        $stmt->bindValue(':firstname', "$firstname");
        $stmt->bindValue(':username', $surname);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':id', $id);
        $stmt->execute();
    }

    Router::redirect("/");
});

Router::route("POST", "/addSpot", function () {
    $name = $_POST["name"];
    $address = $_POST["address"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $category = $_POST["category"];
    $comment = $_POST["comment"];
    $id = $_SESSION["userLogin"]["id"];
    $pdoInstance = Database::connect();
    $stmt = $pdoInstance->prepare('
      INSERT INTO spot (lat, lng, name, address, category, scomment, userid)
        SELECT :lat, :lng, :name, :address, :category, :scomment, :userid
    ');
    $stmt->bindValue(':lat', $latitude);
    $stmt->bindValue(':lng', $longitude);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':category', $category);
    $stmt->bindValue(':scomment', $comment);
    $stmt->bindValue(':userid', $id);
    $stmt->execute();

    Router::redirect("/spotList");
});


Router::route_auth("GET", "/addSpot", $authFunction, function (){
    layoutSetContent("addSpot.php");
});

Router::route_auth("GET", "/spot/edit", $authFunction, function (){
    $id = $_GET["id"];
    $pdoInstance = Database::connect();
    $stmt = $pdoInstance->prepare(' 
       SELECT * FROM spot WHERE id = :id;');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    global $spot;
    $spot = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

    layoutSetContent("editSpot.php");
});

//TODO implement check if user is allowed to do this
Router::route_auth("GET", "/spot/delete", $authFunction, function (){
    $id = $_GET["id"];
    $pdoInstance = Database::connect();
    $stmt = $pdoInstance->prepare('
        DELETE FROM spot
            WHERE id = :id
    ');
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    Router::redirect("/spotList");
});

Router::route_auth("POST", "/spot/update", $authFunction, function (){
    $id = $_POST["id"];
    $name = $_POST["name"];
    $address = $_POST["address"];
    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $category = $_POST["category"];
    $comment = $_POST["comment"];

    $pdoInstance = Database::connect();
    $stmt = $pdoInstance->prepare('
        UPDATE spot SET name = :name,
            address = :address,
            lat = :lat,
            lng = :lng,
            category = :category,
            scomment = :scomment
        WHERE id =:id');
    $stmt->bindValue(':name', "$name");
    $stmt->bindValue(':address', $address);
    $stmt->bindValue(':lat', $latitude);
    $stmt->bindValue(':lng', $longitude);
    $stmt->bindValue(':category', $category);
    $stmt->bindValue(':scomment', $comment);
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    Router::redirect("/spotList");
});

Router::route_auth("GET", "/spotList", $authFunction, function (){
    $pdoInstance = Database::connect();
    $stmt = $pdoInstance->prepare('
        SELECT spot.id, lat, lng, name, address, category, username FROM spot INNER JOIN customer ON customer.id = spot.userid ORDER BY id;
        ');
    // $stmt->bindValue(':uid', $_SESSION["userLogin"]["id"]);
    $stmt->execute();
    global $spots;
    $spots = $stmt->fetchAll(PDO::FETCH_ASSOC);
    layoutSetContent("spotList.php");
});

Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO'], $errorFunction);