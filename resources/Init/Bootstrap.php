<?php

namespace Gc\Resources\Init;

use Thiagorviero\Gc\Controllers\indexController;

abstract class Bootstrap
{

    private array $routes;

    abstract protected function initRoutes();

    function __construct()
    {

        $this->routes = $this->initRoutes();
        $render = $this->takeRoute();

        $controllerPath = 'Thiagorviero\\Gc\\Controllers\\' . ucfirst($render['controller']);

        new $controllerPath($render['action']);
    }

    function takeRoute()
    {
        $currentUrl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach ($this->routes as $key => $route) {
            if ($currentUrl == $route['route']) {
                return $route;
            }
        }

        return $this->routes['notFound'];
    }
}
