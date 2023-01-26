<?php

namespace Gc\Resources\Models;

use PDO;
use Thiagorviero\Gc\Models\Bd\Connection;

abstract class Models
{

    protected $connection;

    function __construct()
    {
        $this->connection = Connection::getConnection();

        if (!is_object($this->connection)) {
            header('Location: /login?error=1');
        }
    }
}
