<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 14.11.2018
 * Time: 22:11
 */

require_once("layout.php");

session_start();

if (isset($_POST['email'])) {
    session_regenerate_id(true);
    $_SESSION['userLogin'] = $_POST['email'];
}

if (!isset($_SESSION["userLogin"])) {
    header("Location: login.php");
}

layoutSetContent("spotList.php");

// logout: session_destroy();