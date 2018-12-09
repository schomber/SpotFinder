<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 09.12.2018
 * Time: 00:31
 */

namespace services;
use domain\Spot;

interface SpotService
{
    public function createSpot(Spot $spot);

    public function readSpot($spotId);

    public function updateSpot(Spot $spot);

    public function deleteSpot($spotId);

    public function listAllSpots();
}