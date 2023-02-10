<?php

namespace Thiagorviero\Gc\Models\Ticket;

use Exception;
use Gc\Resources\Models\DAO;
use InvalidArgumentException;
use PDO;
use PDOException;

class TicketDAO extends DAO
{


    public function edit($id = null, $requestor = null, $attendant = null, $description = null, $status = null, $resolution = null)
    {

        if ($id == null || $requestor == null || $description == null || $status == null) {
            return "Campos obrigatórios (descrição, estado ou solicitante) não preenchidos.";
        }
        $query = 'UPDATE chamados SET CH_DT_ALTERACAO= :dtAlteration,  CH_DESCRICAO=:descrip, ID_USUARIO=:user, ID_ESTADO=:idStatus ';
        if ($attendant != null) {
            $query .= ",ID_ATENDENTE=:attendant ";
        }
        if ($resolution != null) {
            $query .= ",CH_RESOLUCAO=:resolution ";
        }

        $dateTime = date('Y-m-d H:i:s');
        $query .= 'WHERE CH_ID = :id;';
        $this->connection->beginTransaction();
        try {


            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':dtAlteration', $dateTime);
            $stmt->bindValue(':descrip', $description);
            $stmt->bindValue(':user', $requestor);
            $stmt->bindValue(':idStatus', $status);
            if ($attendant != null) {
                $stmt->bindValue(':attendant', $attendant);
            }
            if ($resolution != null) {
                $stmt->bindValue(':resolution', $resolution);
            }
            //$stmt->debugDumpParams();

            $return = $stmt->execute();
            $this->connection->commit();
            return $return;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function create($idRequisitor, $description)
    {
        if (!isset($description) || $description == null) {
            return "Preencha a descrição";
        }
        $date = date('Y-m-d H:i:s');
        //$date = date('Y-m-d');
        $query = 'INSERT INTO CHAMADOS (CH_DT_CRIACAO, CH_DT_ALTERACAO, CH_DESCRICAO, ID_USUARIO, ID_ESTADO) VALUES (:dtCriation, :dtAlteration, :descrip,:idRequisitor, :idStatus)';
        $this->connection->beginTransaction();
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':dtCriation', $date);
            $stmt->bindValue(':dtAlteration', $date);
            $stmt->bindValue(':descrip', $description);
            $stmt->bindValue(':idRequisitor', $idRequisitor);
            //Sempre deve iniciar como aberto
            $stmt->bindValue(':idStatus', 1);
            $stmt->execute();
            $return = $this->connection->lastInsertId();

            $this->connection->commit();
        } catch (Exception $e) {
            $this->connection->rollBack();
            return $e->getMessage();
        }
        return $return;
    }
    public function delete(int $id)
    {
    }
    public function get(int|string $id)
    {
        $query = "SELECT CHAMADOS.CH_DT_CRIACAO, CHAMADOS.CH_ID, CHAMADOS.CH_DESCRICAO, CHAMADOS.CH_RESOLUCAO, CHAMADOS.ID_USUARIO, USUARIOS.US_NOME, USUARIOS.US_ID, CHAMADOS.ID_ATENDENTE, CHAMADOS.ID_ESTADO, ESTADO.ES_DESCRICAO FROM CHAMADOS INNER JOIN USUARIOS ON USUARIOS.US_ID = CHAMADOS.ID_USUARIO INNER JOIN ESTADO ON ESTADO.ES_ID = CHAMADOS.ID_ESTADO WHERE CHAMADOS.CH_ID = :id";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->bindValue(':id', $id, FILTER_SANITIZE_NUMBER_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function getList(string $searchFor = null, string|int $user = null, int $status = 1, int $limit = 20, int $offset = 0)
    {
        $query = "SELECT CHAMADOS.CH_DT_CRIACAO, CHAMADOS.CH_ID, CHAMADOS.CH_DESCRICAO, CHAMADOS.CH_RESOLUCAO, CHAMADOS.ID_USUARIO, USUARIOS.US_NOME, USUARIOS.US_ID, CHAMADOS.ID_ATENDENTE, CHAMADOS.ID_ESTADO, ESTADO.ES_DESCRICAO FROM CHAMADOS INNER JOIN USUARIOS ON USUARIOS.US_ID = CHAMADOS.ID_USUARIO INNER JOIN ESTADO ON ESTADO.ES_ID = CHAMADOS.ID_ESTADO";

        if (isset($searchFor)) {
            $query .= "WHERE CHAMADOS.CH_DESCRICAO LIKE %:searchFor%";
        }
        if (isset($user)) {
            if (str_contains($query, "WHERE")) {
                $query .= " AND";
            } else {
                $query .= " WHERE";
            }
            if (intval($user)) {
                $query .= " USUARIOS.US_ID = :user";
            } else {
                $query .= " USUARIOS.US_NOME = :user";
            }
        }

        if (isset($status)) {
            if (str_contains($query, "WHERE")) {
                $query .= " AND";
            } else {
                $query .= " WHERE";
            }
            $query .= " CHAMADOS.ID_ESTADO = :status";
        }

        $query .= " LIMIT :limit OFFSET :offset";

        $stmt = $this->connection->prepare($query);

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

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
    }

    public function getAllStatus()
    {
        $query = "SELECT ES_DESCRICAO, ES_ID FROM estado";
        try {
            $stmt = $this->connection->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
