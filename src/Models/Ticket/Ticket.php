<?php

namespace Thiagorviero\Gc\Models\Ticket;

use Gc\Resources\Models\Models;

class Ticket extends Models
{
    public function listTickets(string $searchFor = null, string|int $user = null, int $status = 1, int $limit = 20, int $offset = 0)
    {
        $dao = new TicketDAO;
        $dao = $dao->getList($searchFor, $user, $status, $limit, $offset);
        return $dao;
    }
}
