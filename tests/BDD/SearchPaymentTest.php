<?php

use BraspagNonOfficial\Api\Payment;

/**
 * @todo - improve this test with every chance of exception
 *
 * Class AuthorizationTest
 */
class SearchTest extends TestBase
{
    public function testSearchWithValidPaymentIdShouldReturnSaleWithEqualsValue()
    {
        $client = $this->getClient();
        $sale = $this->getSale();
        $originalResponse = $client->createSale($sale);
        $searchResponse = $client->getSale($originalResponse->getPayment()->getPaymentId());
        $this->comparePayments($originalResponse->getPayment(), $searchResponse->getPayment());
    }

    public function testSearchWithWrongPaymentIdShouldThrowException()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionMessage("The request is invalid.");
        $client = $this->getClient();
        $sale = $this->getSale();
        $originalResponse = $client->createSale($sale);
        $wrongPaymentId = str_replace(["1", "2", "3", "4"], "X", $originalResponse->getPayment()->getPaymentId());
        $this->assertEquals("true", $client->getSale($wrongPaymentId));
    }

    protected function comparePayments(Payment $originalResponse, Payment $searchResponse)
    {
        $this->assertEquals($originalResponse->getPaymentId(), $searchResponse->getPaymentId());
        $this->assertEquals($originalResponse->getAcquirerTransactionId(), $searchResponse->getAcquirerTransactionId());
        $this->assertEquals($originalResponse->getAmount(), $searchResponse->getAmount());
        $this->assertEquals($originalResponse->getAuthenticationUrl(), $searchResponse->getAuthenticationUrl());
        $this->assertEquals($originalResponse->getAuthorizationCode(), $searchResponse->getAuthorizationCode());
        $this->assertEquals($originalResponse->getBarCodeNumber(), $searchResponse->getBarCodeNumber());
        $this->assertEquals($originalResponse->getBoletoNumber(), $searchResponse->getBoletoNumber());
        $this->assertEquals($originalResponse->getCapture(), $searchResponse->getCapture());
        $this->assertEquals($originalResponse->getCapturedAmount(), $searchResponse->getCapturedAmount());
        $this->assertEquals($originalResponse->getCapturedDate(), $searchResponse->getCapturedDate());
        $this->assertEquals($originalResponse->getCurrency(), $searchResponse->getCurrency());
        $this->assertEquals($originalResponse->getInstallments(), $searchResponse->getInstallments());
        $this->assertEquals($originalResponse->getExpirationDate(), $searchResponse->getExpirationDate());
        $this->assertEquals($originalResponse->getProofOfSale(), $searchResponse->getProofOfSale());
        $this->assertEquals($originalResponse->getProvider(), $searchResponse->getProvider());

        /**
         * Ask to braspag why this return is not equal
         * searchResponse providerReturnCode is null
         */
//        $this->assertEquals($originalResponse->getProviderReturnCode(), $searchResponse->getProviderReturnCode());
        $this->assertEquals($originalResponse->getStatus(), $searchResponse->getStatus());
    }
}
