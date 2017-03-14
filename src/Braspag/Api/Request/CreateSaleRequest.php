<?php
namespace BraspagNonOffical\Api\Request;

use BraspagNonOffical\Merchant;
use BraspagNonOffical\Environment;
use BraspagNonOffical\Api\Request\AbstractSaleRequest;
use BraspagNonOffical\Api\Sale;

class CreateSaleRequest extends AbstractSaleRequest
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

    public function execute($sale)
    {
        $url = $this->environment->getApiUrl() . 'v2/sales/';

        return $this->sendRequest('POST', $url, $sale);
    }
}