<?php

namespace Thiagorviero\Gc\Models\User;

use Exception;
use Gc\Resources\Models\DAO;
use PDO;

class UserDAO extends DAO
{


    public function edit(int $id)
    {
    }
    public function create()
    {
    }
    public function delete(int $id)
    {
    }
    public function get(int|string $user, $pass = null)
    {
        echo "<br> e1";
        if (is_int($user)) {
            echo "<br> e2";
            $query = "SELECT US.US_ID, US.US_NOME, US.US_SENHA, US.US_DESCRICAO, US.US_DT_CRIACAO, PE.AC_ID  FROM USUARIOS AS US INNER JOIN  PERMITE AS PE on PE.US_ID = PE.US_ID where US.US_ID=:USER";
        } else {
            echo "<br> e3";
            $query = "SELECT US.US_ID, US.US_NOME, US.US_SENHA, US.US_DESCRICAO, US.US_DT_CRIACAO, PE.AC_ID  FROM USUARIOS AS US INNER JOIN  PERMITE AS PE on PE.US_ID = PE.US_ID where US.US_NOME=:USER";
        }
        echo "<br> e4";

        try {
            $this->connection->beginTransaction();
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':USER', $user);
            $stmt->execute();
            //Caso consigam inserir alguma coisa o roolBack irá retornar ao estado anterior
            $this->connection->rollBack();
            $return = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($return['US_SENHA'] == $pass) {
                unset($return['US_SENHA']);
                return $return;
            }
            return  "Combinação de usuário e senha não encontrada";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function getList(string|int $user = null)
    {
        $query = "SELECT US.US_ID, US.US_NOME, US.US_SENHA, US.US_DESCRICAO, US.US_DT_CRIACAO, PE.AC_ID  FROM USUARIOS AS US INNER JOIN  PERMITE AS PE on PE.US_ID = PE.US_ID";

        if (isset($user)) {
            if (is_int($user)) {
                $query .= " WHERE US.US_ID = :user";
            } else {
                $query .= " WHERE US.US_NOME LIKE :user";
            }
        }
        $stmt = $this->connection->prepare($query);
        if (isset($user)) {
            $stmt->bindValue(':user', $user);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getOnlyNames(string|int $user = null)
    {
        //$query = "SELECT US_ID, US_NOME, US FROM USUARIOS";
        $query = "SELECT US.US_ID, US.US_NOME, PE.AC_ID  FROM USUARIOS AS US INNER JOIN  PERMITE AS PE on US.US_ID = PE.US_ID";
        $stmt = $this->connection->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
