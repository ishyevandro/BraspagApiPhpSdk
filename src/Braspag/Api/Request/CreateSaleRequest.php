<?php
namespace BraspagNonOfficial\Api\Request;

use BraspagNonOfficial\Merchant;
use BraspagNonOfficial\Environment;
use BraspagNonOfficial\Api\Request\AbstractSaleRequest;
use BraspagNonOfficial\Api\Sale;

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