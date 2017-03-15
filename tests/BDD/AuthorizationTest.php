<?php

use BraspagNonOfficial\Api\Braspag;
use BraspagNonOfficial\Api\Environment;
use BraspagNonOfficial\Api\Sale;
use BraspagNonOfficial\Merchant;

/**
 * @todo - improve this test with every chance of exception
 *
 * Class AuthorizationTest
 */
class AuthorizationTest extends TestBase
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
        $client->createSale($this->getSale('4242 4242 4242 4242'));//valid format 4242424242424242
    }

    public function testAuthorizationWithInvalidExpirationDateShouldThrowException()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionMessage('Credit Card Expiration Date is invalid');
        $this->expectExceptionCode('126');
        $client = $this->getClient();
        $sale = $this->getSale();
        $payment = $sale->getPayment();
        $creditCard = $payment->getCreditCard();
        $creditCard->setExpirationDate("08/20");//valid format 08/2020
        $client->createSale($sale);
    }

    public function testAuthorizationWithValidDataShouldreturnSalesObject()
    {
        $client = $this->getClient();
        $sale = $this->getSale();
        $this->assertEquals(Sale::class, get_class($client->createSale($sale)));
    }
}
