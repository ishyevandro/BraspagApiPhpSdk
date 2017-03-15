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
class CancelationTest extends TestBase
{
    const STATUS_VOIDED = 10;

    public function testCancelationWithWrongPaymentIdShouldThrowException()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagRequestException::class);
        $this->expectExceptionCode("404");
        $this->expectExceptionMessage("Resource not found");
        $client = $this->getClient();
        $sale = $this->getSale();
        $result = $client->createSale($sale);
        $wrongId = str_replace(["1", "2", "0", "3", "5", "4", "6", "7", "8"], "9", $result->getPayment()->getPaymentId());
        $client->cancelSale($wrongId);
    }

    public function testCancelationWithWrongCharsInPaymentIdShouldThrowException()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionCode("-1");
        $this->expectExceptionMessage("The request is invalid.");
        $client = $this->getClient();
        $sale = $this->getSale();
        $result = $client->createSale($sale);
        $wrongId = str_replace(["1", "2", "0", "3"], "X", $result->getPayment()->getPaymentId());
        $client->cancelSale($wrongId);
    }

    public function testCancelationWithValidPaymentIdShouldreturnPaymentObject()
    {
        $client = $this->getClient();
        $sale = $this->getSale();
        $result = $client->createSale($sale);
        $cancelationResult = $client->cancelSale($result->getPayment()->getPaymentId());
        $this->assertEquals(BraspagNonOfficial\Api\Payment::class, get_class($cancelationResult));
        $this->assertEquals(self::STATUS_VOIDED, $cancelationResult->getStatus());
    }

    public function testCancelationInCanceledPaymentShouldThrowException()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionMessage("Transaction not available to void");
        $this->expectExceptionCode("309");
        $client = $this->getClient();
        $sale = $this->getSale();
        $result = $client->createSale($sale);
        $client->cancelSale($result->getPayment()->getPaymentId());
        $this->assertEquals("true", $client->cancelSale($result->getPayment()->getPaymentId()));
    }

    public function testCancelationInNotAuthorizedPaymentPaymentShouldThrowException()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionMessage("Transaction not available to void");
        $this->expectExceptionCode("309");
        $client = $this->getClient();
        $sale = $this->getSale("0000000000000002");
        $result = $client->createSale($sale);
        $client->cancelSale($result->getPayment()->getPaymentId());
        $this->assertEquals("true", $client->cancelSale($result->getPayment()->getPaymentId()));
    }
}
