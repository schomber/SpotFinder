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

try {
    Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
} catch (HTTPException $exception) {
    $exception->getHeader();
    require_once("view/404.php");
}