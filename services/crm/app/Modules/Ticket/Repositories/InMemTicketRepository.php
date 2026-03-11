<?php

namespace App\Modules\Ticket\Repositories;

use App\Modules\Ticket\Contracts\ITicketRepository;
use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Models\Ticket;

class InMemTicketRepository implements ITicketRepository
{
    public function create(int $customerId, CreateTicketDTO $dto): Ticket
    {
        // Привязываем его к переданному customerId для консистентности
        return Ticket::factory()->make([
            'customer_id' => $customerId,
            'id' => fake()->unique()->numberBetween(1, 1000),
        ]);
    }

    public function hasRecentTicket(string $email, string $phone): bool
    {
        return fake()->boolean();
    }
}
