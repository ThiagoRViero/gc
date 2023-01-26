<?php

namespace Thiagorviero\Gc\Controllers;

use Gc\Resources\Controller\Controller;
use Thiagorviero\Gc\Models\User\Session;

class TicketController extends Controller
{
    function home()
    {
        Session::verifySession();
        header('Location: /panel');
    }

    function listTickets()
    {
        Session::verifySession();
        $this->render('list_tickets', 'layout');
        //require_once $this->getLayout();
    }

    function getLayout()
    {
        Session::verifySession();
        return parse_url($_SERVER['DOCUMENT_ROOT'], PHP_URL_PATH) . '\..\src\Views\Layouts\layout.phtml';
    }
}
