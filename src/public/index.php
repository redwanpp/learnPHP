<?php



use App\PaymentGateway\Paddle\Transaction;

require_once __DIR__ . '/../vendor/autoload.php';

$t = new Transaction(25.0);

$t->proccess();
