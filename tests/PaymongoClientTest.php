<?php declare(strict_types=1);

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Paymongo\Phaymongo\PaymongoClient;
use PHPUnit\Framework\TestCase;

final class PaymongoClientTest extends TestCase {
    public function testGetAuthorizationHeader(): void {
        $client = new PaymongoClient('a', 'b');

        $this->assertSame($client->getAuthorizationHeader(), 'Basic ' . base64_encode('b'));
        $this->assertSame($client->getAuthorizationHeader(true), 'Basic ' . base64_encode('a'));
    }

    public function testCreateRequest(): void {
        $client = new PaymongoClient('a', 'b');

        $payload = array(
            'data' => array(
                'attributes' => array(
                    'amount' => 10000,
                    'payment_method_allowed' => array('gcash', 'credit_card', 'paymaya'),
                    'currency' => 'PHP', // hard-coded for now
                    'description' => 'Sample Description',
                ),
            ),
        );

        $request = $client->createRequest('POST', '/payment_intents', $payload);
        $body = $request->getBody();

        $this->assertTrue($request->hasHeader('Authorization'));
        $this->assertSame($request->getHeader('Authorization')[0], 'Basic ' . base64_encode('b'));
        $this->assertSame($body->getContents(), json_encode($payload));
    }

    public function testSuccessfullyCreatePaymentIntent(): void {
        $mock = new MockHandler([
            new Response(200, ['Content-Type' => 'application/json'], json_encode(array('success' => true))),
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new PaymongoClient('a', 'b', array('handler' => $handlerStack));

        $response = $client->createPaymentIntent(10000, array('gcash', 'credit_card', 'paymaya'), 'Sample Description');

        $this->assertSame($response->getBody()->getContents(), '{"success":true}');
    }

    public function testUnsuccessfullyCreatePaymentIntent(): void {
        $mock = new MockHandler([
            new Response(400, ['Content-Type' => 'application/json'], json_encode(array('success' => false, 'errors' => array()))),
        ]);

        $handlerStack = HandlerStack::create($mock);

        $client = new PaymongoClient('a', 'b', array('handler' => $handlerStack));

        try {
            $response = $client->createPaymentIntent(10000, array('gcash', 'credit_card', 'paymaya'), 'Sample Description');
        } catch (ClientException $e) {
            $response = $e->getResponse();
            $this->assertSame($response->getBody()->getContents(), '{"success":false,"errors":[]}');
        }
    }
}