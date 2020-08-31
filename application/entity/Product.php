<?php

namespace Demoshop\entity;
/**
 * Represents a single product in the result.
 */
class Product
{
    /**
     * Name of the product.
     *
     * @var string
     */
    public $title;

    /**
     * Id of the product.
     *
     * @var Number
     */
    public $productId;

    /**
     * Price of the product.
     *
     * @var Decimal
     */
    public $price;

    /**
     * Product Image.
     *
     * @var String
     */
    public $image;

    /**
     * @var integer
     * Only used for shopping cart products
     */
    public $amount;

}
