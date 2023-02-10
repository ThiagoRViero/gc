<?php

namespace Gc\Resources\Models;

use Exception;
use PDO;
use Thiagorviero\Gc\Models\Bd\Connection;

abstract class DAO
{

    protected PDO $connection;

    function __construct()
    {
        $this->connection = Connection::getConnection();

        if (!is_object($this->connection)) {
            header('Location: /login?error=1');
        }
    }

    abstract protected function edit(int $id);
    //abstract protected function create();
    abstract protected function delete(int $id);
    abstract protected function get(int $id);
    abstract protected function getList();
}
