<?php
namespace Demoshop\Component\Database;
use Demoshop\config\Config;
use \PDO;

/**
 * Class Mysql
 * This class implements DatabaseInterface for Mysql database
 * @package Demoshop\Component\Database
 */
class Mysql implements DatabaseInterface {
    /**
     * @var bool|PDO
     */
    protected $conn = false;  //DB connection resources
    /**
     * @var String
     */
    protected $sql;
    /**
     * @var statement Object
     */
    protected $stmt;

    /**
     * Mysql constructor.
     */
    public function __construct() {
        $config = Config::getConfig();
        $host = isset($config['host'])? $config['host'] : 'localhost';

        $user = isset($config['user'])? $config['user'] : 'root';

        $password = isset($config['password'])? $config['password'] : '';

        $dbname = isset($config['dbname'])? $config['dbname'] : 'shop';

        $port = isset($config['port'])? $config['port'] : '3306';

        try {
            $this->conn = new PDO("mysql:host=$host:$port;dbname=$dbname", $user, $password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

    }

    /**
     * @return bool|PDO
     */
    public function getDB() {
        return $this->conn;
    }

    /**
     * @param array $data
     * @return int
     */
    public function insert($data = array()) {
        $tableName = $data['tableName'];
        $fields = $data['fields'];
        $values = $data['values'];
        $bindParam = $data['bindParam'];
        $sql = "INSERT INTO $tableName ($fields) VALUES ($values)";
        $this->query($sql, $bindParam);
        return $this->getInsertId();
    }

    /**
     * @param array $data
     * @return integer
     */
    public function update($data = array()) {
        $tableName = $data['tableName'];
        $setValue = $data['setValue'];
        $where = $data['where'];
        $bindParam = $data['bindParam'];
        $sql = "UPDATE $tableName SET $setValue where $where";
        $this->query($sql, $bindParam);
        return $this->getRowCount();
    }

    /**
     * @param string $tableName
     * @param int $id
     * @return mixed
     */
    public function delete($tableName="", $id = 0)
    {
        $sql = "DELETE from $tableName where id = $id";
        $this->query($sql);
        return $this->getRowCount();
    }

    /**
     * @return mixed
     */
    public function fetchRow()
    {
        $this->stmt->setFetchMode(PDO::FETCH_OBJ);
        return $this->stmt->fetch();
    }

    /**
     * @return mixed
     */
    public function fetchAll()
    {
        $this->stmt->setFetchMode(PDO::FETCH_OBJ);
        return $this->stmt->fetchAll();
    }

    /**
     * @return int
     */
    public function getInsertId(){
        return (int)$this->conn->lastInsertId();
    }

    /**
     * @return string
     */
    public function getError() {
        return "";
    }

    /**
     * @return integer
     */
    public function getRowCount() {
        return $this->stmt->rowCount();
    }

    /**

     * Execute SQL statement

     * @access public

     * @param $sql string SQL query statement

     * @param $insertValues Array optional parameter for bulk insert

     * @return $result，if succeed, return resrouces; if fail return error message and exit

     */
    public function query($sql, $insertValues = array()) {
        try {
            $this->stmt = $this->conn->prepare($sql);
            if(sizeof($insertValues))
                $this->stmt->execute($insertValues);
            else
                $this->stmt->execute();
            return $this;
        } catch (\Exception $e) {
            //log error here
            return false;
        }

    }
}
