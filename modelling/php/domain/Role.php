<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 05.12.2018
 * Time: 19:45
 */

namespace domain;


class Role
{
    private $id;
    private $role;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @param string
     */
    public function setRole($role)
    {
        $this->role = $role;
    }



}