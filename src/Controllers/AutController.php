<?php

namespace Thiagorviero\Gc\Controllers;

use Exception;
use Gc\Resources\Controller\Controller;
use Gc\Resources\Models\Models;
use InvalidArgumentException;
use Thiagorviero\Gc\Models\User\User;

class AutController extends Controller
{
    function authenticate()
    {

        try {
            if (isset($_POST['user']) && isset($_POST['pass'])) {
                if (!is_string($_POST['user']) || !is_string($_POST['pass'])) {
                    throw new InvalidArgumentException('Dados em formato inválido.');
                }
                $user =  new User;

                echo $user->authenticate($_POST['user'], $_POST['pass']);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
