<?php

namespace Paymongo\Phaymongo;

interface BillingGeneratorInterface {
    public function __construct($order);
    public function getFirstName();
    public function getLastName();
    public function getEmail();
    public function getPhone();
    public function getAddress1();
    public function getAddress2();
    public function getCity();
    public function getState();
    public function getCountry();
    public function getPostalCode();
}