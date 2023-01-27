<?php

namespace Thiagorviero\Gc\Controllers;

use Gc\Resources\Controller\Controller;
use Thiagorviero\Gc\Models\Ticket\Ticket;
use Thiagorviero\Gc\Models\User\Session;

class TicketController extends Controller
{
    protected $tickets;
    function __construct($action)
    {
        $this->tickets = new Ticket;
        parent::__construct($action);
    }
    function home()
    {
        Session::verifySession();
        header('Location: /panel');
    }

    function listTickets()
    {
        Session::verifySession();
        $this->tickets = $this->tickets->listTickets();
        $this->render('list_tickets', 'layout');
    }

    function getLayout()
    {
        Session::verifySession();
        return parse_url($_SERVER['DOCUMENT_ROOT'], PHP_URL_PATH) . '\..\src\Views\Layouts\layout.phtml';
    }
}
