<?php
/**
 * Created by PhpStorm.
 * User: schomber
 * Date: 05.12.2018
 * Time: 19:22
 */

namespace dao;

use database\Database;
use \PDO;

abstract class BasicDAO {
    /**
     * @AttributeType PDO
     */
    protected $pdoInstance;

    /**
     * @access public
     * @param PDO pdoInstance
     * @ParamType pdoInstance PDO
     */
    public function __construct(PDO $pdoInstance = null) {
        if(is_null($pdoInstance)){
            $this->pdoInstance = Database::connect();
        } else {
            $this->pdoInstance = $pdoInstance;
        }
    }
}
?>