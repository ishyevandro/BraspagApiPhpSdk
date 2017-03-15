<?php

use BraspagNonOfficial\Api\Address;
use BraspagNonOfficial\Api\Braspag;
use BraspagNonOfficial\Api\CreditCard;
use BraspagNonOfficial\Api\Customer;
use BraspagNonOfficial\Api\Environment;
use BraspagNonOfficial\Api\Payment;
use BraspagNonOfficial\Api\Sale;
use BraspagNonOfficial\Merchant;

class AuthorizationTest extends PHPUnit_Framework_TestCase
{

    public function testAuthorizationWithWrongAuthenticationShouldThrowException()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionMessage('The provided MerchantId is not in correct format');
        $this->expectExceptionCode('114');
        $merchant = new Merchant("id", "asdasd");
        $client = new Braspag($merchant, Environment::sandbox());
        $sale = $this->getSale();
        $client->createSale($sale);
    }

    public function testAuthorizattionWithWrongCreditCardLengthShouldThrowException()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionMessage('Card Number length exceeded');
        $this->expectExceptionCode('128');
        $client = $this->getClient();
        $client->createSale($this->getSale('4242 4242 4242 4242'));
    }

    public function testAuthorizationWithValidCreditCardShouldReturnSalesObject()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionMessage('Credit Card Expiration Date is invalid');
        $this->expectExceptionCode('126');
        $client = $this->getClient();
        $sale = $this->getSale();
        $payment = $sale->getPayment();
        $creditCard = $payment->getCreditCard();
        $creditCard->setExpirationDate("08/20");
        $client->createSale($sale);
    }

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
        $merchant = new Merchant("5b634d21-9531-47c8-ab4d-6920983e5510", "RTRLVXVPLMPHDLYNJJRPNFWZPOSAAHJJUITWFGNP");
        return new Braspag($merchant, Environment::sandbox());
    }
}
