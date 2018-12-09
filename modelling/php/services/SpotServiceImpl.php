<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 09.12.2018
 * Time: 00:34
 */

namespace services;


use dao\SpotDAO;
use domain\Spot;
use http\HTTPException;
use http\HTTPStatusCode;
use services\AuthServiceImpl;

class SpotServiceImpl implements SpotService
{

    public function createSpot(Spot $spot)
    {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $spotDAO = new SpotDAO();
            $spot->setUserid(AuthServiceImpl::getInstance()->getCurrentCustomerId());
            return $spotDAO->create($spot);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    public function readSpot($spotId)
    {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $spotDAO = new SpotDAO();
            return $spotDAO->read($spotId);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    public function updateSpot(Spot $spot)
    {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $spotDAO = new SpotDAO();
            return $spotDAO->update($spot);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    public function deleteSpot($spotId)
    {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $spotDAO = new SpotDAO();
            $spot = new Spot();
            $spot->setId($spotId);
            $spotDAO->delete($spot);
        }
    }

    public function listAllSpots()
    {
        if(AuthServiceImpl::getInstance()->verifyAuth()){
            $spotDAO = new SpotDAO();
            return $spotDAO->listAllSpots();
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }
}