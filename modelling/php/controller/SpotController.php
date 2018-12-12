<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 08.12.2018
 * Time: 17:49
 */

namespace controller;

use domain\Spot;
use router\Router;
use services\SpotServiceImpl;
use view\LayoutRendering;
use view\TemplateView;

class SpotController
{

    public static function edit(){
        $id = $_GET["id"];
        $view = new TemplateView("editSpot.php");
        $view->spot = (new SpotServiceImpl())->readSpot($id);
        LayoutRendering::basicLayout($view);
    }

    public static function display(){
        $contentView = new TemplateView("spot.php");
        $contentView->spot = (new SpotServiceImpl())->readSpot($_GET["id"]);
        LayoutRendering::basicLayout($contentView);
    }

    public static function update(){
        $spot = new Spot();
        $spot->setId($_POST["id"]);
        $spot->setName($_POST["name"]);
        $spot->setLat($_POST["latitude"]);
        $spot->setLng($_POST["longitude"]);
        $spot->setAddress($_POST["address"]);
        $spot->setCategory($_POST["category"]);
        $spot->setScomment($_POST["comment"]);
        $spot->setUserid($_POST['userid']);

        if ($spot->getId() === "") {
            (new SpotServiceImpl())->createSpot($spot);
        } else {

            (new SpotServiceImpl())->updateSpot($spot);
        }
    }

    public static function create(){
        $contentView = new TemplateView("addSpot.php");
        LayoutRendering::basicLayout($contentView);
    }

    public static function delete(){
        $id = $_GET["id"];
        (new SpotServiceImpl())->deleteSpot($id);

    }

    public static function listAllSpots(){
        $contentView = new TemplateView("spotList.php");
        $contentView->spots = (new SpotServiceImpl())->listAllSpots();
        LayoutRendering::basicLayout($contentView);
    }

    public static function listSpotsBySearch(){
        $contentView = new TemplateView("spotList.php");

        if ($_POST['searchtext'] !== "") {
            $contentView->spots = array_filter((new SpotServiceImpl())->listAllSpots(), function($spot){
                $search = $_POST["searchtext"];
                $spotAddress = $spot->address;
                return (strpos(strtolower($spotAddress), strtolower($search)) !== false);

            });
            LayoutRendering::basicLayout($contentView);
        } else {
            Router::redirect("/");
        }

    }

    public static function addSpotView(){
        LayoutRendering::basicLayout(new TemplateView("addSpot.php"));
    }


}