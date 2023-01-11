<?php

namespace Paymongo\Phaymongo;

use GuzzleHttp\Psr7\Response;

class PaymentMethod extends PaymongoClient {
    public function __construct($public_key, $secret_key, $guzzle_ops = array(), $client_ops = array())
    {
        $this->base_resource_key = 'payment_methods';

        parent::__construct($public_key, $secret_key, $guzzle_ops, $client_ops);
    }

    /**
     * A function to create a Paymongo payment method object
     *
     * @param  string $type
     * @param  mixed $details
     * @param  mixed $billing
     * @param  mixed $metadata
     * @return Response
     */
    public function create($type, $details = null, $billing = null, $metadata = null): Response {
        $attributes = array(
            'type' => $type,
        );

        if (!empty($details)) {
            $attributes['details'] = $billing;
        }

        if (!empty($billing)) {
            $attributes['billing'] = $billing;
        }

        if (!empty($metadata)) {
            $attributes['metadata'] = $metadata;
        }

        $payload = PaymongoUtils::constructPayload($attributes);
        return $this->createResource($payload);
    }
    
    /**
     * A function to retrieve a Paymongo payment method object by ID
     *
     * @param  string $id
     * @return Response
     */
    public function retrieveById($id): Response {
        return $this->retrieveResourceById($id);
    }
}