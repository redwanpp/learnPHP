<?php

use App\App;
use App\Config;
use App\Container;
use App\Controllers\HomeController;
use App\controllers\InvoiceController;
use App\Router;

require_once __DIR__ . "/../vendor/autoload.php";

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

const STORAGE_PATH = __DIR__ . "/../storage/";
const VIEW_PATH = __DIR__ . "/../views";

$container = new Container();
$router = new Router($container);

$router
    ->get('/', [HomeController::class, 'index'])
    ->get('/examples/generator', [\App\controllers\GeneratorController::class, 'index']);



(new App(
    $container,
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();
