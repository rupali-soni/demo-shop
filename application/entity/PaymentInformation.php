<?php


namespace Demoshop\entity;


class PaymentInformation {

    //we can make abstract class here as an enhancement

    /**
     * @var string
     * For Direct debit iBAN
     */
    public $iBan;

    /**
     * @var string
     * For direct debit BIC
     */
    public $BIC;

    /**
     * @var string
     */
    public $bankName;

    /**
     * @var string
     */
    public $cardNumber;

    /**
     * @var integer
     */
    public $cvc;

    /**
     * @var string
     * contains date
     */
    public $expiryDate;



}