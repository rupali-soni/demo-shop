<?php

namespace Demoshop\entity;

/**
 * Represents a single user in result set
 */
class ApiUser
{
    /**
     * @var String
     */
    public $userName;

    /**
     * @var Integer
     */
    public $userId;

    /**
     * @var integer
     * 1 = active, 0 = Inactive
     */
    public $status;
}
