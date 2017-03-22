<?php

use BraspagNonOfficial\Api\Address;
use BraspagNonOfficial\Api\Braspag;
use BraspagNonOfficial\Api\CreditCard;
use BraspagNonOfficial\Api\Customer;
use BraspagNonOfficial\Api\Environment;
use BraspagNonOfficial\Merchant;
use BraspagNonOfficial\Api\Payment;
use BraspagNonOfficial\Api\Sale;


/**
 * Simple test to show how this sdk work.
 *
 * Another tests will be implemented
 *
 * Class SimpleExampleTest
 */
class SimpleExampleTest extends TestBase
{

    public function testAuthorizationWithCapture()
    {
        $sale = new Sale(rand(10000, 9999999999));
        $sale->setCustomer($this->newCustomer());
        /**
         * 15000 = 150.00 (braspag does not accept "." or ",")
         */
        $sale->setPayment($this->newPayment(15000,2));
        /**
         * constants defined in phpunit.xml
         */
        $merchant = new Merchant(MERCHANT_ID, MERCHANT_KEY);
        $braspagClient = new Braspag($merchant, Environment::sandbox());

        /**
         * @var $resultOfCreation Sale
         */
        $resultOfCreation = $braspagClient->createSale($sale);
        /**
         * Checking if status of sale is pre authorized
         */
        $this->assertEquals(self::AUTHORIZED, $resultOfCreation->getPayment()->getStatus());

        /**
         * Try capture
         */
        $saleResult = $braspagClient->captureSale($resultOfCreation->getPayment()->getPaymentId());

        /**
         * Check if status is payment confirmed
         */
        $this->assertEquals(self::PAYMENT_CONFIRMED, $saleResult->getStatus());
    }

    public function testAuthorizationWithCancel()
    {
        $sale = new Sale(rand(10000, 9999999999));
        $sale->setCustomer($this->newCustomer());
        /**
         * 15000 = 150.00 (braspag does not accept "." or ",")
         */
        $sale->setPayment($this->newPayment(15000,2));
        /**
         * constants defined in phpunit.xml
         */
        $merchant = new Merchant(MERCHANT_ID, MERCHANT_KEY);
        $braspagClient = new Braspag($merchant, Environment::sandbox());

        /**
         * @var $resultOfCreation Sale
         */
        $resultOfCreation = $braspagClient->createSale($sale);
        /**
         * Checking if status of sale is pre authorized
         */
        $this->assertEquals(self::AUTHORIZED, $resultOfCreation->getPayment()->getStatus());

        /**
         * Try capture
         */
        $saleResult = $braspagClient->cancelSale($resultOfCreation->getPayment()->getPaymentId());

        /**
         * Check if status is cancelled
         */
        $this->assertEquals(self::VOIDED, $saleResult->getStatus());
    }

    protected function newCustomer()
    {
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
        return $customer;
    }

    protected function newPayment($value, $installments)
    {
        $payment = new Payment();
        $payment->setAmount($value)
            ->setProvider("Simulado")
            ->setInstallments($installments);

        $creditCard = new CreditCard();
        $creditCard->setBrand("Visa")
            ->setCardNumber("0000000000000001")
            ->setExpirationDate("08/2019");
        $creditCard->setHolder("Test da Silva")
            ->setSecurityCode("737");
        $payment->setCreditCard($creditCard);

        return $payment;
    }
}
