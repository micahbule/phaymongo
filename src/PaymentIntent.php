<?php

namespace Paymongo\Phaymongo;

use GuzzleHttp\Psr7\Response;

class PaymentIntent extends PaymongoClient {
    /**
     * A function to create a Paymongo payment intent object to use for transactions
     *
     * @param  int $amount The transaction amount
     * @param  string[] $payment_methods
     * @param  string $description
     * @param  mixed $metadata
     * @return Response
     */
    public function create($amount, $payment_methods, $description, $metadata = null): Response {
        $attributes = array(
            'amount' => $amount * 100,
            'payment_method_allowed' => $payment_methods,
            'currency' => 'PHP', // hard-coded for now
            'description' => $description,    
        );

        if (!empty($metadata)) {
            $attributes['metadata'] = $metadata;
        }

        $payload = array(
            'data' => array(
                'attributes' => $attributes,
            ),
        );

        $request = $this->createRequest('POST', '/payment_intents', $payload);
        return $this->client->send($request);
    }

    /**
     * A function to get a Paymongo payment intent object by ID
     *
     * @param  string $id
     * @return Response
     */
    public function retrieveById($id): Response {
        $request = $this->createRequest('GET', '/payment_intents/' . $id);
        return $this->client->send($request);
    }

    /**
     * A function to attach a Paymongo payment method to a payment intent object
     *
     * @param  string $payment_intent_id
     * @param  string $payment_method_id
     * @param  string $return_url
     * @param  string $client_key
     * @return Response
     */
    public function attachPaymentMethod($payment_intent_id, $payment_method_id, $return_url = null, $client_key = null): Response {
        $attributes = array(
            'payment_method' => $payment_method_id,
        );

        if (!empty($client_key)) {
            $attributes['client_key'] = $client_key;
        }

        if (!empty($return_url)) {
            $attributes['return_url'] = $return_url;
        }

        $payload = array(
            'data' => array(
                'attributes' => $attributes,
            ),
        );

        $request = $this->createRequest('POST', '/payment_intents/' . $payment_intent_id . '/attach', $payload);
        return $this->client->send($request);
    }
}