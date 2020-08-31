<?php


namespace Demoshop\entity;


class Cart {

    /**
     * @var string
     */
    public $type;

    /**
     * @var String
     */
    public $shoppingCartId;

    /**
     * @var Product[]
     */
    public $products;

    /***
     * @var float
     */
    public $sum;

    /**
     * @var string
     */
    public $vatPercent;

    /**
     * @var float
     */
    public $vatSum;

    /**
     * @var float
     */
    public $deliveryCost;

    /**
     * @var float
     */
    public $totalSum;

    /**
     * @var string
     */
    public $currency;
}