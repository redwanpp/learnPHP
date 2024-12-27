<?php

namespace App\Services;

class SalesTaxService
{

    public function __construct()
    {
    }

    public function calculate(float $amount, array $customer)
    {
//        sleep(1);

        return $amount * 6.5 / 100;
    }


}