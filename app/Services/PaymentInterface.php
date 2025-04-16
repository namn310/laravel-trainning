<?php

namespace App\Services;

interface PaymentInterface
{
    public function makePayment($data);
}
