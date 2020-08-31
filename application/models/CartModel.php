<?php
namespace Demoshop\models;
/**
 * This class defines all the features related to Shopping Cart.
 */
class CartModel extends Dbmodel {
    /**
     * @var string
     * table name
     */
    private $_tableName = 't_cart';

    /**
     * CartModel constructor.
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * get all products from database
     * @param $data
     * @param int $imgAttribId
     * @return mixed
     */
    public function getAllProducts($data) {
        $sql = "SELECT c.id as cid, c.cart_json as cart_data from $this->_tableName as c
                where c.id = :customerId";
        return $this->db->query($sql, $data)->fetchRow();
    }
}