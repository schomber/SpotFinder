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
        $spotDAO = new SpotDAO();
        if(AuthServiceImpl::getInstance()->verifyAuth() && (!is_null($spotDAO->read($spotId)))) {
            $spotDAO = new SpotDAO();
            return $spotDAO->read($spotId);
        }
        throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
    }

    public function updateSpot(Spot $spot)
    {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            if(AuthServiceImpl::getInstance()->getCurrentCustomerId() == $spot->getUserid() || AuthServiceImpl::getInstance()->verfiyAdmin()) {
                $spotDAO = new SpotDAO();
                return $spotDAO->update($spot);
            }
        } else {
            throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
        }
    }

    public function deleteSpot($spotId)
    {
        if(AuthServiceImpl::getInstance()->verifyAuth()) {
            $spotDAO = new SpotDAO();
            $spot = new Spot();
            $spot->setUserid($spotDAO->read($spotId)->getUserid());
            if(AuthServiceImpl::getInstance()->getCurrentCustomerId() == $spot->getUserid() || AuthServiceImpl::getInstance()->verfiyAdmin()) {
                $spotDAO = new SpotDAO();
                $spot = new Spot();
                $spot->setId($spotId);
                $spotDAO->delete($spot);
            }
        } else {
            throw new HTTPException(HTTPStatusCode::HTTP_401_UNAUTHORIZED);
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