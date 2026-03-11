<?php

namespace App\Modules\Ticket\Contracts;

use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Models\Ticket;

interface ITicketRepository
{
    public function create(int $customerId, CreateTicketDTO $dto): Ticket;

    public function hasRecentTicket(string $email, string $phone): bool;

    public function findOrFail(int $id): Ticket;
}
