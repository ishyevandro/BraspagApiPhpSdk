<?php
namespace BraspagNonOfficial\Api;

use BraspagNonOfficial\Merchant;
use BraspagNonOfficial\Api\Request\CreateSaleRequest;
use BraspagNonOfficial\Api\Request\QuerySaleRequest;
use BraspagNonOfficial\Api\Request\UpdateSaleRequest;

/**
 * The Braspag Ecommerce SDK front-end;
 */
class Braspag
{

    private $merchant;

    private $environment;

    /**
     * Create an instance of Braspag choosing the environment where the
     * requests will be send
     *
     * Braspag constructor.
     * @param Merchant $merchant
     * @param Environment|null $environment
     */
    public function __construct(Merchant $merchant, Environment $environment = null)
    {
        if ($environment == null) {
            $environment = Environment::production();
        }

        $this->merchant = $merchant;
        $this->environment = $environment;
    }

    /**
     * Send the Sale to be created and return the Sale with payment id and the status
     * returned by Braspag.
     *
     * @param Sale $sale
     * @return Sale
     */
    public function createSale(Sale $sale)
    {
        $createSaleRequest = new CreateSaleRequest($this->merchant, $this->environment);

        return $createSaleRequest->execute($sale);
    }

    /**
     * Query a Sale on Braspag by paymentId
     *
     * @param $paymentId
     * @return Sale
     */
    public function getSale($paymentId)
    {
        $querySaleRequest = new QuerySaleRequest($this->merchant, $this->environment);

        return $querySaleRequest->execute($paymentId);
    }

    /**
     * Cancel a Sale on Braspag by paymentId and speficying the amount
     *
     * @param $paymentId
     * @param null $amount
     * @return Payment
     */
    public function cancelSale($paymentId, $amount = null)
    {
        $updateSaleRequest = new UpdateSaleRequest('void', $this->merchant, $this->environment);

        $updateSaleRequest->setAmount($amount);

        return $updateSaleRequest->execute($paymentId);
    }

    /**
     * Capture a Sale on Braspag by paymentId and specifying the amount and the
     * serviceTaxAmount
     *
     * @param $paymentId
     * @param null $amount
     * @param null $serviceTaxAmount
     * @return null
     */
    public function captureSale($paymentId, $amount = null, $serviceTaxAmount = null)
    {
        $updateSaleRequest = new UpdateSaleRequest('capture', $this->merchant, $this->environment);

        $updateSaleRequest->setAmount($amount);
        $updateSaleRequest->setServiceTaxAmount($serviceTaxAmount);

        return $updateSaleRequest->execute($paymentId);
    }
}