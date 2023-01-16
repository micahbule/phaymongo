<?php

use Paymongo\Phaymongo\PaymongoUtils;

it('can check if billing value is set', function () {
    expect(PaymongoUtils::is_billing_value_set('apple'))->toBeTrue();
    expect(PaymongoUtils::is_billing_value_set(''))->toBeFalsy();
});

it('can get the order class type', function () {
    expect(PaymongoUtils::getOrderClassType('woocommerce'))->toBe('WooCommerceOrder');
    expect(PaymongoUtils::getOrderClassType('magento'))->toBe('MagentoOrder');
});

it('can throw an error if invalid order class type', function () {
    PaymongoUtils::getOrderClassType('prestashop');
})->throws(Exception::class, 'Invalid order class type');

it('can construct Paymongo payload', function () {
    expect(PaymongoUtils::constructPayload(['foo' => 'bar']))->toBe(['data' => ['attributes' => ['foo' => 'bar']]]);
});