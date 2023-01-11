<?php

namespace Paymongo\Phaymongo;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

define('PAYMONGO_BASE_URL', 'https://api.paymongo.com/v1');

class PaymongoClient {
    protected $public_key;
    protected $secret_key;
    protected $client;

    public function __construct(string $public_key, string $secret_key, array $client_ops = array())
    {
        $this->public_key = $public_key;
        $this->secret_key = $secret_key;

        $default_client_ops = array(
            'base_uri' => PAYMONGO_BASE_URL,
        );
        
        $client = new Client(array_merge($default_client_ops, $client_ops));

        $this->client = $client;
    }

    public function getAuthorizationHeader(bool $use_public_key = false) {
        $key = $use_public_key ? $this->public_key : $this->secret_key;

        return 'Basic ' . base64_encode($key);
    }

    public function createRequest(string $method, string $url, array $payload = null, bool $use_public_key = false) {
        $request = new Request($method, $url, array(
            'Authorization' => $this->getAuthorizationHeader($use_public_key),
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ));

        if (!empty($payload)) {
            $request = $request->withBody(\GuzzleHttp\Psr7\Utils::streamFor(json_encode($payload)));
        }

        return $request;
    }
}