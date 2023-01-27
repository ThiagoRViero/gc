<?php

namespace Thiagorviero\Gc\Models\Ticket;

use Gc\Resources\Models\Models;

class Ticket extends Models
{
    public function listTickets(string $searchFor = null, string|int $user = null, int $status = null)
    {
        $dao = new TicketDAO;
        $dao = $dao->getList($searchFor, $user, $status);
        return $dao;
    }
}
