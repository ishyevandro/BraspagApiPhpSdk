<?php
namespace BraspagNonOfficial\Api\Request;

use BraspagNonOfficial\Api\Request\AbstractSaleRequest;
use BraspagNonOfficial\Environment;
use BraspagNonOfficial\Api\Sale;
use BraspagNonOfficial\Merchant;

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