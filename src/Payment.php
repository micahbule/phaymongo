<?php

namespace Paymongo\Phaymongo;

use GuzzleHttp\Psr7\Response;

class Payment extends PaymongoClient {
    /**
     * A function to create a Paymongo payment object
     *
     * @param  int $amount
     * @param  string $source_id
     * @param  string $source_type
     * @param  string $description
     * @param  string $statement_descriptor
     * @param  mixed $metadata
     * @return Response
     */
    public function create($amount, $source_id, $source_type, $description = null, $statement_descriptor = null, $metadata = null): Response {
        $attributes = array(
            'amount' => $amount * 100,
            'currency' => 'PHP', // hard-coded for now
            'source' => array(
                'id' => $source_id,
                'type' => $source_type,
            ),
        );

        if (!empty($description)) {
            $attributes['description'] = $description;
        }

        if (!empty($statement_descriptor)) {
            $attributes['statement_descriptor'] = $statement_descriptor;
        }

        if (!empty($metadata)) {
            $attributes['metadata'] = $metadata;
        }

        $payload = array(
            'data' => array(
                'attributes' => $attributes,
            ),
        );

        $request = $this->createRequest('POST', '/payments', $payload);
        return $this->client->send($request);
    }
    
    /**
     * A function to retrieve a Paymongo payment object by ID
     *
     * @param  string $id
     * @return Response
     */
    public function retrieveById($id): Response {
        $request = $this->createRequest('GET', '/payments/' . $id);
        return $this->client->send($request);
    }
    
    /**
     * A function to retrieve multiple Paymongo payment objects
     *
     * @param  int $before
     * @param  int $after
     * @param  int $limit
     * @return Response
     */
    public function retrieveAll($before = null, $after = null, $limit = null): Response {
        $queries = array();

        if (!empty($before)) {
            $queries['before'] = $before;
        }

        if (!empty($after)) {
            $queries['before'] = $after;
        }

        if (!empty($limit)) {
            $queries['before'] = $limit;
        }

        $request = $this->createRequest('GET', '/payments');
        return $this->client->send($request, ['query' => $queries]);
    }
}