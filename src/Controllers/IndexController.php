<?php

namespace Thiagorviero\Gc\Controllers;

use Gc\Resources\Controller\Controller;

class IndexController extends Controller
{
    function login()
    {
        $this->render('login', 'layoutLogin');
    }
    function notFound()
    {

        echo 'Pagina não encontrada';
    }
}
