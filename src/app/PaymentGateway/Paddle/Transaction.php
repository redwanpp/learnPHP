<?php

declare(strict_types=1);

namespace App\PaymentGateway\Paddle;

class Transaction {
    public float $amount;

    public function __construct(float $amount)
    {
        $this->amount = $amount;
    }

    public function proccess()
    {
        echo 'Processing '.$this->amount.' transaction';
    }
}