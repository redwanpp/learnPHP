<?php

namespace App\Services;

class SaleTaxService
{

    public function __construct()
    {
    }

    public function calculate(float $amout, array $customer)
    {
        sleep(1);

        return $amout * 6.5 / 100;
    }


}