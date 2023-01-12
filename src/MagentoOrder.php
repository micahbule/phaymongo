<?php

namespace Paymongo\Phaymongo;

class MagentoOrder implements BillingGeneratorInterface {
    protected $order;
    protected $billing_address;

    public function __construct($order)
    {
        $this->order = $order;
        $this->billing_address = $order->getBillingAddress();
    }

    public function getFirstName()
    {
        $this->billing_address->getFirstName();
    }

    public function getLastName()
    {
        $this->billing_address->getLastName();
    }

    public function getEmail()
    {
        $this->billing_address->getEmail();
    }

    public function getPhone()
    {
        $this->billing_address->getTelephone();
    }

    public function getAddress1()
    {
        $this->billing_address->getStreetLine(1);
    }

    public function getAddress2()
    {
        $this->billing_address->getStreetLine(2);
    }

    public function getCity()
    {
        $this->billing_address->getCity();
    }

    public function getState()
    {
        $this->billing_address->getRegion();
    }

    public function getCountry()
    {
        $this->billing_address->getCountryId();
    }

    public function getPostalCode()
    {
        $this->billing_address->getPostcode();
    }
}