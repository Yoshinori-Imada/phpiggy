<?php

declare(strict_types=1);

namespace App;

class Router
{
    private array $routes = [];

    public function add(string $method, string $path, array $controller)
    {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller
        ];
    }

    public function dispatch(string $path, string $method)
    {
        foreach ($this->routes as $route) {
            if ($route['path'] === $path && $route['method'] === $method) {
                [$class, $function] = $route['controller'];
                $controller = new $class();
                $controller->$function();
                return;
            }
        }

        $this->notFound();
    }

    private function notFound()
    {
        http_response_code(404);
        echo "404 - Page Not Found";
    }
}