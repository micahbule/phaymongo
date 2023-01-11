<?php

namespace Paymongo\Phaymongo;

use GuzzleHttp\Psr7\Response;

class Source extends PaymongoClient {
    /**
     * A function to create a Paymongo source object to use for transactions
     *
     * @param  int $amount The transaction amount
     * @param  string $type
     * @param  string $success_url
     * @param  string $failed_url
     * @param  object $billing
     * @param  object $metadata
     * @return Response
     */
    public function create($amount, $type, $success_url, $failed_url, $billing = null, $metadata = null): Response {
        $attributes = array(
            'type' => $type,
            'amount' => $amount * 100,
            'currency' => 'PHP', // hard-coded for now
            'redirect' => array(
                'success' => $success_url,
                'failed' => $failed_url,
            ),
        );

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

        $request = $this->createRequest('POST', '/sources', $payload);
        return $this->client->send($request);
    }
    
    /**
     * A function to retrieve a Paymongo source object by ID
     *
     * @param  string $id
     * @return Response
     */
    public function retrieveById($id): Response {
        $request = $this->createRequest('GET', '/sources/' . $id);
        return $this->client->send($request);
    }
}