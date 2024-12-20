<?php

namespace App\Services;

class EmailService
{

    public function __construct()
    {
    }

    public function sendEmail(array $to, string $template)
    {
        sleep(1);

        return true;
    }

}