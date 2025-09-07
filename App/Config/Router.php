<?php

namespace App\Config;

class Router
{
  private array $routes = [];

  public function get(string $uri, array $action): void
  {
    $this->addRoute('GET', $uri, $action);
  }

  public function post(string $uri, array $action): void
  {
    $this->addRoute('POST', $uri, $action);
  }

  public function put(string $uri, array $action): void
  {
    $this->addRoute('PUT', $uri, $action);
  }

  public function delete(string $uri, array $action): void
  {
    $this->addRoute('DELETE', $uri, $action);
  }

  private function addRoute(string $method, string $uri, array $action): void
  {
    $this->routes[$method][] = [
      'pattern' => rtrim($uri, '/'),
      'action' => $action
    ];
  }

  public function dispatch(string $method, string $uri): void
  {
    $uri = rtrim($uri, '/') ?: '/';

    foreach ($this->routes[$method] ?? [] as $route) {
      $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([a-zA-Z0-9_-]+)', $route['pattern']);
      $pattern = str_replace('/', '\/', $pattern);
      $regex = '/^' . $pattern . '$/';

      if (preg_match($regex, $uri, $matches)) {
        array_shift($matches); // remove full match
        [$controller, $methodName] = $route['action'];
        (new $controller)->$methodName(...$matches);
        exit;
      }
    }

    // Route not found
    \App\Helpers\JsonResponseHelper::send([
      'error' => '404 Not Found'
    ], 404);
  }
}
