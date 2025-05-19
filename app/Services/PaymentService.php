<?php

namespace App\Services;

use App\Services\PaymentInterface;

class PaymentService
{
    private $paymentClass;
    public function __construct(PaymentInterface $class)
    {
        $this->paymentClass = $class;
    }
    public function processPayment($data)
    {
        return $this->paymentClass->createPayment($data);
    }
}
