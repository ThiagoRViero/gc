<?php

namespace Thiagorviero\Gc\Models\User;

use Exception;
use Gc\Resources\Models\Models;
use PDO;


class Session extends Models
{
    public function create_session(string $id, string $name, string $description, $dtCriation, array $listAccess)
    {
        $this->initSession();

        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['description'] = $description;
        $_SESSION['dtCriation'] = $dtCriation;
        $_SESSION['listAccess'] = $listAccess;
    }
    public function get()
    {
        $this->initSession();

        $return[] = $_SESSION['id'];
        $return[] = $_SESSION['name'];
        $return[] = $_SESSION['description'];
        $return[] = $_SESSION['dtCriation'];
        $return[] = $_SESSION['listAccess'];
    }

    static public function verifySession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['id'])) {
            header('Location: /login');
        }
    }

    static public function logout()
    {
        echo ('teste');
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION['id'])) {
            $_SESSION = [];
            unset($_SESSION);
            session_destroy();
            header('Location: /login');
        }
    }

    private function initSession()
    {
        if (!isset($_SESSION)) {
            session_start();
        }
    }
}
