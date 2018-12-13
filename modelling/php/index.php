<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:11
 */


require_once("config/Autoloader.php");

use router\Router;
use http\HTTPException;
use controller\CustomerController;
use controller\SpotController;
use controller\PDFController;
use controller\RoleController;
use controller\AuthController;
use services\AuthServiceImpl;
use controller\CustomerPasswordResetController;

session_start();

$authFunction = function () {
    if (AuthController::authenticate()) {
        return true;
    }
    Router::redirect("/login");
    return false;
};

Router::route_auth("GET", "/", $authFunction, function () {
    SpotController::listAllSpots();

});

Router::route("GET", "/login", function () {
    CustomerController::loginView();
});

Router::route("POST", "/login", function () {
    AuthController::login();
    Router::redirect("/");
});

Router::route("GET", "/register", function () {
    CustomerController::registerView();
});

Router::route("POST", "/register", function () {
    CustomerController::register();
    Router::redirect("/");
});

Router::route("GET", "/password/request", function () {
    CustomerPasswordResetController::requestView();
});

Router::route("POST", "/password/request", function () {
    CustomerPasswordResetController::resetEmail();
    Router::redirect("/login");
});

Router::route("POST", "/password/reset", function () {
    CustomerPasswordResetController::reset();
    Router::redirect("/login");
});

Router::route("GET", "/password/reset", function () {
    CustomerPasswordResetController::resetView();
});


Router::route("GET", "/logout", function () {
    AuthController::logout();
    Router::redirect("/login");
});

Router::route_auth("GET", "/userList", $authFunction, function (){
    CustomerController::readAll();
});

Router::route_auth("GET", "/user/delete", $authFunction, function (){
    CustomerController::delete();
    Router::redirect("/userList");
});

Router::route_auth("GET", "/user/edit", $authFunction, function (){
    CustomerController::edit();
});

Router::route_auth("POST", "/user/update", $authFunction, function (){
    CustomerController::update();
    Router::redirect("/");
});

Router::route("POST", "/addSpot", function () {
    SpotController::update();
    Router::redirect("/");
});

Router::route_auth("GET", "/addSpot", $authFunction, function (){
    SpotController::create();
});

Router::route_auth("GET", "/spot/edit", $authFunction, function (){
    SpotController::edit();
});

Router::route_auth("GET", "/spot/display", $authFunction, function (){
    SpotController::display();
});

Router::route_auth("GET", "/spot/pdf", $authFunction, function (){
    PDFController::generatePDFSpot();
});

Router::route_auth("GET", "/spot/delete", $authFunction, function (){
    SpotController::delete();
    Router::redirect("/");
});

Router::route_auth("GET", "/user/role/createAdmin", $authFunction, function (){
    RoleController::create();
    Router::redirect("/spotList");
});

Router::route_auth("POST", "/spot/update", $authFunction, function (){
    SpotController::update();
    Router::redirect("/");
});

Router::route_auth("POST", "/spotList", $authFunction, function (){
    SpotController::listSpotsBySearch();
});

try {
    Router::call_route($_SERVER['REQUEST_METHOD'], $_SERVER['PATH_INFO']);
} catch (HTTPException $exception) {
    $exception->getHeader();
    controller\ErrorController::show404();
}