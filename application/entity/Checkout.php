<?php


namespace Demoshop\entity;


class Checkout {

    /**
     * @var Cart
     */
    public $cart;

    /**
     * @var Address
     */
    public $shippingAddress;

    /**
     * @var Address
     */
    public $billingAddress;

    /**
     * @var integer
     * If shipping address and delivery address are same then this value will be 1
     */
    public $isSameAddress;

    /**
     * @var string
     * Direct debit, Invoice or Credit card
     */
    public $paymentType;

    /**
     * @var PaymentInformation
     */
    public $paymentInformation;

    /**
     * @var string
     */
    public $customerEmailAddress;

    /**
     * @var integer
     */
    public $customerId;

    /**
     * @var integer
     */
    public $newsletterAbo;

}