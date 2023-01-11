<?php

namespace Paymongo\Phaymongo;

use GuzzleHttp\Psr7\Response;

class PaymentMethod extends PaymongoClient {
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

        $payload = array(
            'data' => array(
                'attributes' => $attributes,
            ),
        );

        $request = $this->createRequest('POST', '/payment_methods', $payload);
        return $this->client->send($request);
    }
    
    /**
     * A function to retrieve a Paymongo payment method object by ID
     *
     * @param  string $id
     * @return Response
     */
    public function retrieveById($id): Response {
        $request = $this->createRequest('GET', '/payment_methods/' . $id);
        return $this->client->send($request);
    }
}