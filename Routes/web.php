<?php

$router->get('/', [App\Controllers\HomeController::class, 'index']);

$router->post('/api/user', [App\Controllers\UserController::class, 'store']);
$router->get('/api/user', [App\Controllers\UserController::class, 'index']);
$router->delete('/api/user/all', [App\Controllers\UserController::class, 'deleteAll']);
$router->get('/api/user/{id}', [App\Controllers\UserController::class, 'show']);
$router->put('/api/user/{id}', [App\Controllers\UserController::class, 'update']);
$router->delete('/api/user/{id}', [App\Controllers\UserController::class, 'delete']);
