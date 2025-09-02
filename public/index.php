<?php

use App\Config\Router;

header('Content-Type: application/json');

require_once __DIR__ . '/../vendor/autoload.php';

$router = new Router();

require_once __DIR__ . '/../Routes/web.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($method, $uri);
