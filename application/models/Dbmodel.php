<?php
namespace Demoshop\models;
use Demoshop\Component\Database\Mysql;
/**
 * This class defines all the features related database.
 * Parent class
 * Class Dbmodel
 * @package Demoshop\models
 */
class Dbmodel{
    /**
     * Dbmodel constructor.
     * here we are creating object of database and it will be availbale in all the child classes
     */
    public function __construct() {
        $mysql = new Mysql();
        $this->db = $mysql;
    }
}