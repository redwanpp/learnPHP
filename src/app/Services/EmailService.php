<?php

namespace App\Services;

class EmailService
{

    public function __construct()
    {
    }

    public function send(array $to, string $template): bool
    {
//        sleep(1);

        return true;
    }

}