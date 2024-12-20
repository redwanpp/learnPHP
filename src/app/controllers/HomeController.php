<?php

declare(strict_types = 1);

namespace App\Controllers;

USE App\App;
use App\Models\Invoice;
use App\Models\SignUp;
use App\Models\User;
use App\View;
use PDO;

class HomeController
{
    public function index():View
    {
        $db = App::db();

        $email = 'redwan130@gmail.com';
        $name = 'Red';
        $amount = 10000;

        $userModel = new User();
        $invoiceModel = new Invoice();

        $invoiceId = (new SignUp($userModel, $invoiceModel))->register(
            [
                'email' => $email,
                'name' => $name,
            ],
            [
                'amount' => $amount,
            ]
        );


        return View::make('index', ['invoice' => $invoiceModel->find($invoiceId)]);
    }

}