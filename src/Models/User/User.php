<?php

namespace Thiagorviero\Gc\Models\User;

use Exception;
use Gc\Resources\Models\Models;
use PDO;

class User extends Models
{

    public function authenticate($user, $pass)
    {
        if (is_int($user)) {
            $query = "SELECT US.US_ID, US.US_NOME, US.US_SENHA, US.US_DESCRICAO, US.US_DT_CRIACAO, PE.AC_ID  FROM USUARIOS AS US INNER JOIN  PERMITE AS PE on PE.US_ID = PE.US_ID where US.US_ID=:USER";
        } else {
            $query = "SELECT US.US_ID, US.US_NOME, US.US_SENHA, US.US_DESCRICAO, US.US_DT_CRIACAO, PE.AC_ID  FROM USUARIOS AS US INNER JOIN  PERMITE AS PE on US.US_ID = PE.US_ID where US.US_NOME=:USER";
        }

        try {
            $this->connection->beginTransaction();
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':USER', $user);
            $stmt->execute();
            //Caso consigam inserir alguma coisa o roolBack irá retornar ao estado anterior
            $this->connection->rollBack();
            $return = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (isset($return[0]['US_SENHA'])) {
                if ($return[0]['US_SENHA'] == $pass) {
                    unset($return['US_SENHA']);

                    $access = array();
                    foreach ($return as $key => $value) {
                        $access[] = $value['AC_ID'];
                    }
                    $session = new Session;
                    $session->create_session(

                        $return[0]['US_ID'],
                        $return[0]['US_NOME'],
                        $return[0]['US_DESCRICAO'],
                        $return[0]['US_DT_CRIACAO'],
                        $access
                    );
                    return 'true';
                }
            }
            return  "Combinação de usuário e senha não encontrada";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    function listUserNames()
    {
        $list = new UserDAO;
        $list = $list->getOnlyNames();
        $filterList = array();
        $userList[] = ['US_ID' => null, 'US_NOME' => null, 'US_ACCESS' => []];
        $idAnterior = -1;
        $i = -1;

        foreach ($list as $user) {

            $id = intVal($user['US_ID']);

            if ($id != $idAnterior) {
                $i++;
                $filterList[$i]['US_ID'] = $user['US_ID'];
                $filterList[$i]['US_NOME'] = $user['US_NOME'];
                $idAnterior = $user['US_ID'];
            }
            $filterList[$i]['US_ACCESS'][] = $user['AC_ID'];
        }
        return $filterList;
    }
}
