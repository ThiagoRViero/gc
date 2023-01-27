<?php

namespace Thiagorviero\Gc\Models\Ticket;

use Exception;
use Gc\Resources\Models\DAO;
use InvalidArgumentException;
use PDO;
use PDOException;

class TicketDAO extends DAO
{


    public function edit(int $id)
    {
    }
    public function create()
    {
        //INSERT INTO `chamados` (`CH_DT_CRIACAO`, `CH_ID`, `CH_DESCRICAO`, `ID_USUARIO`, `ID_ATENDENTE`, `ID_ESTADO`) VALUES ('2023-01-26', NULL, 'Estou testando a inserção 2', '1', '1', '1');
    }
    public function delete(int $id)
    {
    }
    public function get(int|string $user)
    {
    }
    public function getList(string $searchFor = null, string|int $user = null, int $status = null)
    {
        $query = "SELECT CHAMADOS.CH_DT_CRIACAO, CHAMADOS.CH_ID, CHAMADOS.CH_DESCRICAO, CHAMADOS.ID_USUARIO, USUARIOS.US_NOME, USUARIOS.US_ID, CHAMADOS.ID_ATENDENTE, CHAMADOS.ID_ESTADO, ESTADO.ES_DESCRICAO FROM CHAMADOS INNER JOIN USUARIOS ON USUARIOS.US_ID = CHAMADOS.ID_USUARIO INNER JOIN ESTADO ON ESTADO.ES_ID = CHAMADOS.ID_ESTADO";

        if (isset($searchFor)) {
            $query .= "WHERE CHAMADOS.CH_DESCRICAO LIKE %:searchFor%";
        }
        if (isset($user)) {
            if (str_contains($query, "WHERE")) {
                $query .= " AND";
            }
            if (is_int($user)) {
                $query .= " USUARIOS.US_ID = :user";
            } else {
                $query .= " USUARIOS.US_NOME = :user";
            }
        }

        if (isset($status)) {
            if (str_contains($query, "WHERE")) {
                $query .= " AND";
            }
            $query .= " CHAMADOS.ID_ESTADO = :status";
        }

        $stmt = $this->connection->prepare($query);

        if (isset($searchFor)) {
            $stmt->bindValue(':searchFor', $searchFor);
        }
        if (isset($user)) {
            $stmt->bindValue(':user', $user);
        }
        if (isset($status)) {
            $stmt->bindValue(':status', $status);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);


        //SELECT CHAMADOS.CH_DT_CRIACAO, CHAMADOS.CH_ID, CHAMADOS.CH_DESCRICAO, CHAMADOS.ID_USUARIO, USUARIOS.US_NOME, CHAMADOS.ID_ATENDENTE, CHAMADOS.ID_ESTADO FROM CHAMADOS INNER JOIN USUARIOS ON USUARIOS.US_ID = CHAMADOS.ID_USUARIO

    }
}
