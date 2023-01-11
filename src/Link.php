<?php

namespace Paymongo\Phaymongo;

use GuzzleHttp\Psr7\Response;

class Link extends PaymongoClient {
    public function __construct()
    {
        $this->base_resource_key = 'links';
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
        return $this->client->send($request, array('query' => array('reference_number' => $refNum)));
    }

    public function archive($id) {
        $request = $this->createRequest('POST', '/' . $this->base_resource_key . '/' . $id . '/archive');
        return $this->client->send($request);
    }

    public function unarchive($id) {
        $request = $this->createRequest('POST', '/' . $this->base_resource_key . '/' . $id . '/unarchive');
        return $this->client->send($request);
    }
}