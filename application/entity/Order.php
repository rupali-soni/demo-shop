<?php

namespace Demoshop\entity;

/**
 * Represents a single order.
 */
class Order
{
    /**
     * E.g.: "40dc9802-c8d9-4da7-a9cb-711e0a192c8d"
     *
     * @var String
     */
    public $orderId;

    /**
     * E.g.: "NX-123478"
     * @var String
     */
    public $orderNumber;

    /**
     * @var string
     */
    public $customerName;

    /**
     * @var string
     */
    public $customerEmail;

    /**
     * @var string
     */
    public $deliveryAddress;

    /**
     * @var string
     */
    public $newsletterAbo;
}
