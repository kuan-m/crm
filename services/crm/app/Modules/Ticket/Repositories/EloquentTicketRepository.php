<?php

namespace App\Modules\Ticket\Repositories;

use App\Modules\Ticket\Contracts\ITicketRepository;
use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Models\Ticket;

class EloquentTicketRepository implements ITicketRepository
{
    public function create(int $customerId, CreateTicketDTO $dto): Ticket
    {
        return Ticket::create($dto->toTicketAttributes($customerId));
    }

    public function hasRecentTicket(string $email, string $phone): bool
    {
        return Ticket::query()
            ->whereHas('customer', function ($q) use ($email, $phone) {
                $q->where('email', $email)->orWhere('phone', $phone);
            })
            ->where('created_at', '>=', now()->subDay())
            ->exists();
    }

    public function findOrFail(int $id): Ticket
    {
        return Ticket::findOrFail($id);
    }
}
