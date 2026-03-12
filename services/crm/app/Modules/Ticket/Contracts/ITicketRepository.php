<?php

namespace App\Modules\Ticket\Contracts;

use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Enums\TicketStatus;
use App\Modules\Ticket\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ITicketRepository
{
    public function create(int $customerId, CreateTicketDTO $dto): Ticket;

    public function hasRecentTicket(string $email, string $phone): bool;

    public function findOrFail(int $id): Ticket;

    public function show(int $id): Ticket;

    public function getStatistics(): array;

    public function paginateWithFilters(array $filters, int $perPage = 15): LengthAwarePaginator;

    public function updateStatus(int $id, TicketStatus $status): array;
}
