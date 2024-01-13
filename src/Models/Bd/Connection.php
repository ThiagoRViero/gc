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
            try{
                $file = file_get_contents("bd/criar.sql");
                $con = new PDO("mysql:host=localhost;", 'root', null);
                $con->beginTransaction();
                $stmt = $con->prepare($file);
                $stmt->execute();
                $con->commit(); 
                

            }catch(Exception $e2){
                return 'Erro ao se conectar no banco de dados';
            }
            
            return 'Erro ao se conectar no banco de dados';
        }
    }
}

//print_r(Connection::getConnection());
