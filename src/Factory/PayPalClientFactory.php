<?php


namespace App\Factory;


use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;

class PayPalClientFactory
{
    private $clientId;
    private $clientSecret;

    /**
     * PayPalClientFactory constructor.
     * @param $clientId
     * @param $clientSecret
     */
    public function __construct($clientId, $clientSecret)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
    }

    public function create()
    {
        return new PayPalHttpClient(new SandboxEnvironment($this->clientId, $this->clientSecret));
    }
}