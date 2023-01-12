<?php

namespace Paymongo\Phaymongo;

class PaymongoUtils {
    public static function is_billing_value_set($value) {
        return isset($value) && $value !== '';
    }

    public static function generateBillingObject($order, $type) {
        $billing = array();

        $orderClassType = $type === 'woocommerce' ? 'WooCommerceOrder' : 'MagentoOrder';
        $orderClass = new $orderClassType($order);

        $billing_first_name = $orderClass->getFirstName();
        $billing_last_name = $orderClass->getLastName();
        $has_billing_first_name = self::is_billing_value_set($billing_first_name);
        $has_billing_last_name = self::is_billing_value_set($billing_last_name);

        if ($has_billing_first_name && $has_billing_last_name) {
            $billing['name'] = $billing_first_name . ' ' . $billing_last_name;
        }

        $billing_email = $orderClass->getEmail();
        $has_billing_email = self::is_billing_value_set($billing_email);

        if ($has_billing_email) {
            $billing['email'] = $billing_email;
        }

        $billing_phone = $orderClass->getPhone();
        $has_billing_phone = self::is_billing_value_set($billing_phone);

        if ($has_billing_phone) {
            $billing['phone'] = $billing_phone;
        }

        $billing_address = self::generateBillingAddress($orderClass);

        if (count($billing_address) > 0) {
            $billing['address'] = $billing_address;
        }

        return $billing;
    }

    public static function generateBillingAddress($order) {
        $billing_address = array();

        $billing_address_1 = $order->getAddress1();
        $has_billing_address_1 = self::is_billing_value_set($billing_address_1);

        if ($has_billing_address_1) {
            $billing_address['line1'] = $billing_address_1;
        }

        $billing_address_2 = $order->getAddress2();
        $has_billing_address_2 = self::is_billing_value_set($billing_address_2);

        if ($has_billing_address_2) {
            $billing_address['line2'] = $billing_address_2;
        }

        $billing_city = $order->getCity();
        $has_billing_city = self::is_billing_value_set($billing_city);

        if ($has_billing_city) {
            $billing_address['city'] = $billing_city;
        }

        $billing_state = $order->getState();
        $has_billing_state = self::is_billing_value_set($billing_state);

        if ($has_billing_state) {
            $billing_address['state'] = $billing_state;
        }

        $billing_country = $order->getCountry();
        $has_billing_country = self::is_billing_value_set($billing_country);

        if ($has_billing_country) {
            $billing_address['country'] = $billing_country;
        }

        $billing_postcode = $order->getPostalCode();
        $has_billing_postcode = self::is_billing_value_set($billing_postcode);

        if ($has_billing_postcode) {
            $billing_address['postal_code'] = $billing_postcode;
        }

        return $billing_address;
    }

    public static function constructPayload($attributes) {
        return array(
            'data' => array(
                'attributes' => $attributes,
            ),
        );
    }
}