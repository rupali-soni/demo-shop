<?php
namespace Demoshop\models;
/**
 * This class defines all the features related to Shopping Cart.
 */
class OrderModel extends Dbmodel {
    /**
     * @var string
     */
    private $_tableName = 't_cart';

    /**
     * OrderModel constructor.
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * insert product in cart
     * @param $data
     * @return int
     */
    public function insert($data) {
        return $this->db->insert($data);
    }

    /**
     * Function to start transaction
     */
    public function startTransaction() {
        $conn = $this->db->getDB();
        $conn->beginTransaction();
    }

    /**
     * function to commit transaction in database
     */
    public function commitTransaction() {
        $conn = $this->db->getDB();
        $conn->commit();
    }

    /**
     * function to rollback previous transaction
     */
    public function rollbackTransaction() {
        $conn = $this->db->getDB();
        $conn->rollback();
    }
}