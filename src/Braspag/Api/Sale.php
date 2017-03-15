<?php
namespace BraspagNonOfficial\Api;

use BraspagNonOfficial\Api\BraspagSerializable;

class Sale implements BraspagSerializable
{

    private $merchantOrderId;

    private $customer;

    private $payment;

    public function __construct($merchantOrderId = null)
    {
        $this->setMerchantOrderId($merchantOrderId);
    }

    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this));
    }

    public function populate(\stdClass $data)
    {
        if (isset($data->Customer)) {
            $this->customer = new Customer();
            $this->customer->populate($data->Customer);
        }

        if (isset($data->Payment)) {
            $this->payment = new Payment();
            $this->payment->populate($data->Payment);
        }

        if (isset($data->MerchantOrderId)) {
            $this->merchantOrderId = $data->MerchantOrderId;
        }
    }

    public static function fromJson($json)
    {
        $object = json_decode($json);

        $sale = new Sale();
        $sale->populate($object);

        return $sale;
    }

    public function customer($name)
    {
        $customer = new Customer($name);

        $this->setCustomer($customer);

        return $customer;
    }

    public function payment($amount, $installments = 1)
    {
        $payment = new Payment($amount, $installments);

        $this->setPayment($payment);

        return $payment;
    }

    public function getMerchantOrderId()
    {
        return $this->merchantOrderId;
    }

    public function setMerchantOrderId($merchantOrderId)
    {
        $this->merchantOrderId = $merchantOrderId;
        return $this;
    }

    public function getCustomer()
    {
        return $this->customer;
    }

    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return \BraspagNonOfficial\Api\Payment;
     */
    public function getPayment()
    {
        return $this->payment;
    }

    public function setPayment($payment)
    {
        $this->payment = $payment;
        return $this;
    }
}