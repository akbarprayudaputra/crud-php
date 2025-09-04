<?php

$router->get('/', [App\Controllers\HomeController::class, 'index']);

$router->post('/api/user', [App\Controllers\UserController::class, 'store']);
