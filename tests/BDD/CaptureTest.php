<?php

use BraspagNonOfficial\Api\Payment;

/**
 * @todo - improve this test with every chance of exception
 *
 * Class CaptureTest
 */
class CaptureTest extends TestBase
{

    public function testTryCaptureCancelledOrderShouldThrowEception()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionMessage('Transaction not available to capture');
        $this->expectExceptionCode('308');
        $client = $this->getClient();
        $sale = $client->createSale($this->getSale());

        $paymentId = $sale->getPayment()->getPaymentId();
        $client->cancelSale($paymentId);
        $client->captureSale($paymentId);
    }

    public function testTryCaptureDeniedOrderShouldthrownException()
    {
        $this->expectException(BraspagNonOfficial\Api\Request\BraspagError::class);
        $this->expectExceptionMessage('Transaction not available to capture');
        $this->expectExceptionCode('308');
        $client = $this->getClient();
        $sale = $client->createSale($this->getSale('0000000000000002'));

        $paymentId = $sale->getPayment()->getPaymentId();
        $client->captureSale($paymentId);
    }

    public function testCaptureShouldReturnPaymentObject()
    {
        $client = $this->getClient();
        $sale = $client->createSale($this->getSale());

        $paymentId = $sale->getPayment()->getPaymentId();
        /**
         * @var $response Payment
         */
        $response = $client->captureSale($paymentId);
        $this->assertEquals(self::PAYMENT_CONFIRMED, $response->getStatus());
    }
}
