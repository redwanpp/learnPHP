<?php

namespace App\Services;

class PaymentGatewayService
{

    public function __construct()
    {
    }

    public function charge(array $customer, float $amout, float $tax): bool
    {
//        sleep(1);

        return (bool) mt_rand(0, 1);
    }


}