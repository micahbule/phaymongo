<?php

namespace Paymongo\Phaymongo;

use GuzzleHttp\Psr7\Response;

class Link extends PaymongoClient {
    public function __construct($public_key, $secret_key, $guzzle_ops = array(), $client_ops = array())
    {
        $this->base_resource_key = 'links';

        parent::__construct($public_key, $secret_key, $guzzle_ops, $client_ops);
    }

    public function create($amount, $description, $remarks = null): Response {
        $attributes = array(
            'amount' => $amount,
            'description' => $description,
        );

        if (!empty($remarks)) {
            $attributes['remarks'] = $remarks;
        }

        $payload = PaymongoUtils::constructPayload($attributes);
        return $this->createResource($payload);
    }

    public function retrieveById($id): Response {
        return $this->retrieveResourceById($id);
    }

    public function retrieveByReferenceNumber($refNum): Response {
        $request = $this->createRequest('GET', '/' . $this->base_resource_key);
        return $this->sendRequest($request, array('query' => array('reference_number' => $refNum)));
    }

    public function archive($id) {
        $request = $this->createRequest('POST', '/' . $this->base_resource_key . '/' . $id . '/archive');
        return $this->sendRequest($request);
    }

    public function unarchive($id) {
        $request = $this->createRequest('POST', '/' . $this->base_resource_key . '/' . $id . '/unarchive');
        return $this->sendRequest($request);
    }
}