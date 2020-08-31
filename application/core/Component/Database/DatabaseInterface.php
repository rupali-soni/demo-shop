<?php

namespace Demoshop\Component\Database;
/**
 * Interface DatabaseInterface
 * @package Demoshop\Component\Database
 * All the methods related to database operations can be declared here
 */
interface DatabaseInterface {
    /**
     * get database connection (e.g. PDO Object)
     * @return mixed
     */
    public function getDB();

    /**
     * Insert record into database
     * @return mixed
     */
    public function insert();

    /**
     * Update record in database
     * @return mixed
     */
    public function update();

    /**
     * delete record from DB
     * @param string $tableName
     * @param int $id
     * @return mixed
     */
    public function delete($tableName = "", $id = 0);

    /**
     * Fetch Single row from database
     * @return mixed
     */
    public function fetchRow();

    /**
     * get all row from database
     * @return mixed
     */
    public function fetchAll();

    /**
     * get last inserted Id
     * @return integer
     */
    public function getInsertId();

    /**
     * Get affected rows from database
     * @return Integer
     */
    public function getError();
}
