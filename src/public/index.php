<?php



use App\PaymentGateway\Paddle\Transaction;

require_once __DIR__ . '/../vendor/autoload.php';

$transaction = new Transaction(25.0);

$transaction->amount = 125;

$transaction->proccess();
