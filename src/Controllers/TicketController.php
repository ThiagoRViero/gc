<?php

namespace Thiagorviero\Gc\Controllers;

use Gc\Resources\Controller\Controller;

class TicketController extends Controller
{
    function home()
    {
        header('Location: /panel');
    }

    function listTickets()
    {
        $this->render('list_tickets', 'layout');
        //require_once $this->getLayout();
    }

    function getLayout()
    {
        return parse_url($_SERVER['DOCUMENT_ROOT'], PHP_URL_PATH) . '\..\src\Views\Layouts\layout.phtml';
    }
}
