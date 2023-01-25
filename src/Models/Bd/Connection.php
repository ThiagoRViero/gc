<?php

namespace Thiagorviero\Gc\Models\Bd;

use PDO;
use PDOException;

class Connection
{

    static function getConnection(): PDO | PDOException
    {
        try {
            return new PDO("mysql:host=localhost;dbname=gc", 'root', null);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
}

//print_r(Connection::getConnection());
