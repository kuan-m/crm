<?php

namespace App\Modules\Ticket\Repositories;

use App\Modules\Ticket\Contracts\ITicketRepository;
use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Enums\TicketStatus;
use App\Modules\Ticket\Exceptions\TicketNotFound;
use App\Modules\Ticket\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\LengthAwarePaginator as PaginationLengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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

    public function findOrFail(int $id): Ticket
    {
        if (fake()->boolean(80)) {
            return Ticket::factory()->make([
                'id' => $id,
                'customer_id' => fake()->numberBetween(1, 10),
            ]);
        }

        throw new TicketNotFound("Ticket {$id} not found");
    }

    public function show(int $id): Ticket
    {
        return $this->findOrFail($id);
    }

    public function getStatistics(): array
    {
        return [
            'today' => fake()->numberBetween(0, 10),
            'week' => fake()->numberBetween(10, 50),
            'month' => fake()->numberBetween(50, 200),
        ];
    }

    public function paginateWithFilters(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        return new PaginationLengthAwarePaginator(
            [],
            100,
            $perPage,
            1,
            ['path' => Paginator::resolveCurrentPath()]
        );
    }

    /**
     * @return array{0: bool, 1: ?\Illuminate\Support\Carbon}
     */
    public function updateStatus(int $id, TicketStatus $status): array
    {
        return [fake()->boolean(50), fake()->boolean() ? now() : null];
    }
}
