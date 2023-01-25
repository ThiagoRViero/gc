<?php

namespace Thiagorviero\Gc\Routes;

use Gc\Resources\Init\Bootstrap;

class Routes extends Bootstrap
{

    private $route;
    protected function initRoutes()
    {
        $this->route['notFound'] = [
            'route' => '',
            'controller' => 'IndexController',
            'action' => 'notFound'
        ];
        $this->route['index'] = [
            'route' => '/',
            'controller' => 'TicketController',
            'action' => 'home'
        ];
        $this->route['login'] = [
            'route' => '/login',
            'controller' => 'IndexController',
            'action' => 'login'
        ];
        $this->route['panel'] = [
            'route' => '/panel',
            'controller' => 'TicketController',
            'action' => 'listTickets'
        ];

        return $this->route;
    }
}
