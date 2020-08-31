<?php
namespace Demoshop\models;
/**
 * This class defines all the features related to URL routing.
 */
class ApiUsersModel extends Dbmodel {
    /**
     * @var string
     */
    private $_tableName = 't_api_users';

    /**
     * UsersModel constructor.
     */
    public function __construct(){
        parent::__construct();
    }

    /**
     * get data for existing user
     * @param array $bindParam
     * @param string $whereStr
     * @return mixed
     */
    public function getUser($bindParam = array(), $whereStr = 'id=:id') {
        $sql = "SELECT id, user_name, status from $this->_tableName WHERE $whereStr";
        return $this->db->query($sql, $bindParam)->fetchRow();
    }

    /**
     * Insert data for new api user
     * @param $bindParam
     * @return int
     */
    public function insert($bindParam) {
        $data['tableName'] = $this->_tableName;
        $data['fields'] = 'user_name, password, status';
        $data['values'] = ':userName, :password, :status';
        $data['bindParam'] = $bindParam;
        return $this->db->insert($data);
    }

}