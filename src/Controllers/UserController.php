<?php

namespace Thiagorviero\Gc\Controllers;

use Gc\Resources\Controller\Controller;
use Thiagorviero\Gc\Models\Ticket\Ticket;
use Thiagorviero\Gc\Models\User\Session;
use Thiagorviero\Gc\Models\User\User;

class UserController extends Controller
{
    function listUsernames()
    {
        Session::verifySession();

        $listUsernames = new User;
        $listUsernames = $listUsernames->listUsernames();
        echo json_encode($listUsernames);
    }
}
