<?php

require_once __DIR__ . '/request.php';
require_once __DIR__ . '/response.php';

abstract class Middleware
{
    /** Return false to stop dispatching after producing a response or redirect. */
    abstract public function run($request, $response): bool;
}

final class Route
{
    private string $url;
    private string $verb;
    private string $controller;
    private string $method;
    private array $middlewares;
    private array $params = [];

    public function __construct(string $url, string $verb, string $controller, string $method, array $middlewares = [])
    {
        $this->url = trim($url, '/');
        $this->verb = strtoupper($verb);
        $this->controller = $controller;
        $this->method = $method;
        $this->middlewares = $middlewares;

        foreach ($middlewares as $middleware) {
            if (!$middleware instanceof Middleware) {
                throw new InvalidArgumentException('Route middleware must extend Middleware.');
            }
        }
    }

    public function match(string $url, string $verb): bool
    {
        if ($this->verb !== strtoupper($verb)) {
            return false;
        }

        $routeParts = $this->url === '' ? [] : explode('/', $this->url);
        $url = trim($url, '/');
        $urlParts = $url === '' ? [] : explode('/', $url);

        if (count($routeParts) !== count($urlParts)) {
            return false;
        }

        $params = [];
        foreach ($routeParts as $index => $part) {
            $value = rawurldecode($urlParts[$index]);
            if (str_starts_with($part, ':')) {
                if ($value === '') {
                    return false;
                }
                $params[substr($part, 1)] = $value;
            } elseif ($part !== $value) {
                return false;
            }
        }

        $this->params = $params;
        return true;
    }

    public function dispatch($request, $response, array $globalMiddlewares): bool
    {
        $request->params = (object) $this->params;

        foreach (array_merge($globalMiddlewares, $this->middlewares) as $middleware) {
            if ($middleware->run($request, $response) === false) {
                return false;
            }
            if ($response->hasFinished()) {
                return false;
            }
        }

        $controller = $this->controller;
        $method = $this->method;
        (new $controller())->$method($request, $response);
        return true;
    }
}

final class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private Request $request;
    private Response $response;

    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function addMiddleware(Middleware $middleware): void
    {
        $this->middlewares[] = $middleware;
    }

    public function addRoute(string $url, string $verb, string $controller, string $method, array $middlewares = []): void
    {
        $this->routes[] = new Route($url, $verb, $controller, $method, $middlewares);
    }

    public function route(string $url, string $verb): void
    {
        foreach ($this->routes as $route) {
            if ($route->match($url, $verb)) {
                $route->dispatch($this->request, $this->response, $this->middlewares);
                return;
            }
        }

        http_response_code(404);
        echo 'Ruta no encontrada';
    }
}
