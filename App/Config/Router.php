<?php

namespace App\Config;

class Router
{
  private $routes = [];

  public function get($uri, $action)
  {
    $this->addRoute('GET', $uri, $action);
  }

  public function post($uri, $action)
  {
    $this->addRoute('POST', $uri, $action);
  }

  public function put($uri, $action)
  {
    $this->addRoute('PUT', $uri, $action);
  }

  public function delete($uri, $action)
  {
    $this->addRoute('DELETE', $uri, $action);
  }

  private function addRoute($method, $uri, $action)
  {
    $this->routes[$method][$uri] = $action;
  }

  public function dispatch($method, $uri)
  {
    $uri = rtrim($uri, '/') ?: '/';

    $action = $this->routes[$method][$uri] ?? null;

    if (!$action) {
      \App\Helpers\JsonResponseHelper::send([
        'error' => '404 Not Found'
      ], 404);
    }

    [$controller, $method] = $action;
    (new $controller)->$method();
  }
}
