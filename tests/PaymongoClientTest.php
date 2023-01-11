<?php

/**
 * @runInSeparateProcess
 */

use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Paymongo\Phaymongo\PaymongoClient;

it('can create a request without payload', function () {
    $client = new PaymongoClient('a', 'b');

    $request = $client->createRequest('GET', '/');

    expect($request->hasHeader('Authorization'))->toBeTrue();
    expect($request->getHeader('Authorization')[0])->toBe('Basic ' . base64_encode('b'));
    expect((string) $request->getBody())->toBe('');
});

it('can create a request with payload', function () {
    $client = new PaymongoClient('a', 'b');

    $request = $client->createRequest('POST', '/', ['foo' => 'bar']);

    expect($request->hasHeader('Authorization'))->toBeTrue();
    expect($request->getHeader('Authorization')[0])->toBe('Basic ' . base64_encode('b'));
    expect((string) $request->getBody())->toBe('{"foo":"bar"}');
});

it('can send a request and return unwrapped data by default', function () {
    $mockHandler = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], '{"data":"bar"}'),
    ]);

    $handlerStack = HandlerStack::create($mockHandler);
    $client = new PaymongoClient('a', 'b', [], ['handler' => $handlerStack]);

    $request = $client->createRequest('GET', '/');
    $response = $client->sendRequest($request);

    expect($response)->toBe('bar');
});

it('can send a request and return wrapped data', function () {
    $mockHandler = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], '{"data":"bar"}'),
    ]);

    $handlerStack = HandlerStack::create($mockHandler);
    $client = new PaymongoClient('a', 'b', ['unwrap' => false], ['handler' => $handlerStack]);

    $request = $client->createRequest('GET', '/');
    $response = $client->sendRequest($request);

    expect($response)->toBe(['data' => 'bar']);
});

it('can send a request and return the HTTP message instance', function () {
    $mockHandler = new MockHandler([
        new Response(200, ['Content-Type' => 'application/json'], '{"data":"bar"}'),
    ]);

    $handlerStack = HandlerStack::create($mockHandler);
    $client = new PaymongoClient('a', 'b', ['return_response' => true], ['handler' => $handlerStack]);

    $request = $client->createRequest('GET', '/');
    $response = $client->sendRequest($request);

    expect($response)->toBeInstanceOf(Response::class);
    expect($response->getBody()->__toString())->toBe('{"data":"bar"}');
});

it('can create a resource', function () {
    $client = mock('Paymongo\Phaymongo\PaymongoClient')->makePartial();

    $payload = ['data' => 'bar'];

    $client->shouldReceive('createRequest')
        ->withArgs(['POST', '/', $payload, false])
        ->atLeast()
        ->times(1)
        ->andReturn(true);

    $client->shouldReceive('sendRequest')
        ->withArgs([true, []])
        ->atLeast()
        ->times(1);

    $client->createResource($payload);
});

it('can retrieve a resource by ID', function () {
    $client = mock('Paymongo\Phaymongo\PaymongoClient')->makePartial();

    $id = 1;

    $client->shouldReceive('createRequest')
        ->withArgs(['GET', '//' . $id])
        ->atLeast()
        ->times(1)
        ->andReturn(true);

    $client->shouldReceive('sendRequest')
        ->withArgs([true, []])
        ->atLeast()
        ->times(1);

    $client->retrieveResourceById($id);
});