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
        $this->route['login'] = [
            'route' => '/login',
            'controller' => 'indexController',
            'action' => 'login'
        ];
        $this->route['authenticate'] = [
            'route' => '/authenticate',
            'controller' => 'autController',
            'action' => 'authenticate'
        ];
        $this->route['userNames'] = [
            'route' => '/usernames',
            'controller' => 'UserController',
            'action' => 'listUsernames'
        ];
        $this->route['logout'] = [
            'route' => '/logout',
            'controller' => 'autController',
            'action' => 'logout'
        ];
        $this->route['panel'] = [
            'route' => '/panel',
            'controller' => 'TicketController',
            'action' => 'listTickets'
        ];
        $this->route['newTicket'] = [
            'route' => '/new_ticket',
            'controller' => 'TicketController',
            'action' => 'newTicket'
        ];
        $this->route['createTicket'] = [
            'route' => '/createTicket',
            'controller' => 'TicketController',
            'action' => 'createTicket'
        ];
        $this->route['editTicket'] = [
            'route' => '/edit_ticket',
            'controller' => 'TicketController',
            'action' => 'editTicket'
        ];
        $this->route['saveEditTicket'] = [
            'route' => '/save_edit',
            'controller' => 'TicketController',
            'action' => 'saveEditTicket'
        ];

        return $this->route;
    }
}
