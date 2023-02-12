<?php

namespace Thiagorviero\Gc\Models\Ticket;

use Gc\Resources\Models\Models;

class Ticket extends Models
{
    private $dao;
    public function __construct()
    {
        $this->dao = new TicketDAO;
        parent::__construct();
    }
    public function listTickets(string $searchFor = null, $user = null, int $status = 1, int $limit = 20, int $offset = 0)
    {

        $list['tickets'] = $this->dao->getList($searchFor, $user, $status, $limit, $offset);
        $list['countTickets'] = $this->dao->getCountList($searchFor, $user, $status, $limit, $offset);
        $list['numberOfPages'] = ceil(intval($list['countTickets']) / $limit);

        return $list;
    }

    public function createTicket($user, $description)
    {

        if (!isset($description) || $description == null) {
            return "Preencha a descrição.";
        }
        return $this->dao->create($user, $description);
    }

    public function getTicket($id)
    {
        return $this->dao->get($id);
    }

    public function getAllStatus()
    {
        return $this->dao->getAllStatus();
    }

    public function editTicket($id = null, $requestor = null, $attendant = null, $description = null, $status = null, $resolution = null)
    {
        if ($id == null || $requestor == null || $description == null || $status == null) {
            return "Campos obrigatórios (descrição, estado ou solicitante) não preenchidos.";
        }

        return $this->dao->edit($id, $requestor, $attendant, $description, $status, $resolution);
    }
}
