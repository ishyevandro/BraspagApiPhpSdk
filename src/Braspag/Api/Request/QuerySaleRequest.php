<?php
namespace BraspagNonOffical\Api\Request;

use BraspagNonOffical\Api\Request\AbstractSaleRequest;
use BraspagNonOffical\Environment;
use BraspagNonOffical\Merchant;

class QuerySaleRequest extends AbstractSaleRequest
{

    private $environment;

    public function __construct(Merchant $merchant, Environment $environment)
    {
        parent::__construct($merchant);

        $this->environment = $environment;
    }

    protected function unserialize($json)
    {
        return Sale::fromJson($json);
    }

    public function execute($paymentId)
    {
        $url = $this->environment->getApiQueryURL() . 'v2/sales/' . $paymentId;

        return $this->sendRequest('GET', $url);
    }
}