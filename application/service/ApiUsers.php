<?php
namespace Demoshop\service;
use Demoshop\entity\ApiUser;
use Demoshop\models\ApiUsersModel;
/**
 * This class for implementing all the operations related to Users
 */
class ApiUsers
{
    /**
     * @var ApiUsersModel
     */
    private $oApiUserModel;

    /**
     * Users constructor.
     */
    public function __construct(
        ApiUsersModel $oApiUserModel
    ) {
        $this->oApiUserModel = $oApiUserModel;
    }

    /**
     * @param $username
     * @param $password
     * @return bool|mixed
     */
    public function authenticateUser($username, $password) {
        $bindParam = array(
            ":username" => $username,
            ":password" => $password,
            ":status"   => 1
        );
        $where = 'user_name = :username AND password = :password AND status = :status';
        $user = $this->oApiUserModel->getUser($bindParam, $where);
        if($user) {
            $apiUserObject = new ApiUser();
            $apiUserObject->userId = $user->id;
            $apiUserObject->userName = $user->user_name;
            $apiUserObject->status = $user->status;
            return $apiUserObject;
        }
        else
            return false;
    }

    /**
     * add new user entry in database
     * @param $data
     * @return int
     */
    public function addUser($data) {
        return $this->oApiUserModel->insert($data);
    }
}