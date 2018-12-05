<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 05.12.2018
 * Time: 19:45
 */

namespace domain;


class Spot
{
    private $id;
    private $lat;
    private $lng;
    private $name;
    private $address;
    private $category;
    private $comment;
    private $userid;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return double
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param double
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return double
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param double
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param string
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param int
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }


}