<?php

use BraspagNonOfficial\Api\Address;
use BraspagNonOfficial\Api\Braspag;
use BraspagNonOfficial\Api\CreditCard;
use BraspagNonOfficial\Api\Customer;
use BraspagNonOfficial\Api\Environment;
use BraspagNonOfficial\Api\Payment;
use BraspagNonOfficial\Api\Sale;
use BraspagNonOfficial\Merchant;

class TestBase extends PHPUnit_Framework_TestCase
{

    CONST NOT_FINISHED = 0;
    CONST AUTHORIZED = 1;
    CONST PAYMENT_CONFIRMED = 2;
    CONST DENIED = 3;
    CONST VOIDED = 10;
    CONST REFUNDED = 11;
    CONST PENDING = 12;
    CONST ABORTED = 13;
    CONST SCHEDULED = 20;

    protected function getSale($creditCardNumber = "0000000000000001")
    {
        $sale = new Sale(rand(10000, 9999999999));
        $customer = new Customer();
        $customer->setName("Comprador de Testes")
            ->setEmail("compradordetestes@braspag.com.br")
            ->setBirthDate("1991-01-02");
        $address = new Address();
        $address->setCity("Rio de Janeiro")
            ->setComplement("Sala 934")
            ->setCountry("BRA")
            ->setNumber("160")
            ->setState("RJ")
            ->setStreet("Av. Marechal Câmara")
            ->setZipCode("20020-080");
        $customer->setAddress($address);
        $sale->setCustomer($customer);

        $payment = new Payment();
        $payment->setAmount(15900)
            ->setProvider("Simulado")
            ->setInstallments(3);

        $creditCard = new CreditCard();
        $creditCard->setBrand("Visa")
            ->setCardNumber($creditCardNumber)
            ->setExpirationDate("08/2019");
        $creditCard->setHolder("Test da Silva")
            ->setSecurityCode("737");
        $payment->setCreditCard($creditCard);
        $sale->setPayment($payment);

        return $sale;
    }

    protected function getClient()
    {
        /**
         * constants defined in phpunit.xml
         */
        $merchant = new Merchant(MERCHANT_ID, MERCHANT_KEY);
        return new Braspag($merchant, Environment::sandbox());
    }
}
