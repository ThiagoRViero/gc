<?php

namespace Thiagorviero\Gc\Models\Bd;

use Exception;
use PDO;
use PDOException;

class Connection
{

    static function getConnection(): PDO | string
    {
        try {
            return new PDO("mysql:host=localhost;dbname=gc", 'root', null);
        } catch (Exception $e) {
            return 'Erro ao se conectar no banco de dados';
        }
    }
}

//print_r(Connection::getConnection());
