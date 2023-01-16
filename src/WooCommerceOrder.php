<?php

namespace Paymongo\Phaymongo;

class WooCommerceOrder implements BillingGeneratorInterface {
    protected $order;    

    public function __construct($order)
    {
        $this->order = $order;
    }

    public function getFirstName()
    {
        $this->order->get_billing_first_name();
    }

    public function getLastName()
    {
        $this->order->get_billing_last_name();
    }

    public function getEmail()
    {
        $this->order->get_billing_email();
    }

    public function getPhone()
    {
        $this->order->get_billing_phone();
    }

    public function getAddress1()
    {
        $this->order->get_billing_address_1();
    }

    public function getAddress2()
    {
        $this->order->get_billing_address_2();
    }

    public function getCity()
    {
        $this->order->get_billing_city();
    }

    public function getState()
    {
        $this->order->get_billing_state();
    }

    public function getCountry()
    {
        $this->order->get_billing_country();
    }

    public function getPostalCode()
    {
        $this->order->get_billing_postcode();
    }
}