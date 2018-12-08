<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 08.12.2018
 * Time: 17:49
 */

namespace controller;

use dao\SpotDAO;
use domain\Spot;
use view\LayoutRendering;
use view\TemplateView;

class SpotController
{
    public static function edit(){
        $id = $_GET["id"];
        $contentView = new TemplateView("editSpot.php");
        $contentView->spot = (new SpotDAO())->read($id);
        LayoutRendering::basicLayout($contentView);
    }

    public static function create(){
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
    }

    public static function udpate(){
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
    }

    public static function delete(){
        $id = $_GET["id"];
        $spotDAO = new SpotDAO();
        $spot = new Spot();
        $spot->setId($id);
        $spotDAO->delete($spot);
    }

    public static function listAllSpots(){
        $contentView = new TemplateView("spotList.php");
        $contentView->spots = (new SpotDAO())->listAllSpots();
        LayoutRendering::basicLayout($contentView);
    }

    public static function addSpotView(){
        LayoutRendering::basicLayout(new TemplateView("addSpot.php"));
    }


}