<?php

namespace App\Modules\Ticket\Repositories;

use App\Modules\Ticket\Contracts\ITicketRepository;
use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Enums\TicketStatus;
use App\Modules\Ticket\Filters\TicketListFilter;
use App\Modules\Ticket\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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

    public function show(int $id): Ticket
    {
        return Ticket::query()
            ->with(['customer', 'media'])
            ->findOrFail($id);
    }

    public function getStatistics(): array
    {
        return [
            'today' => Ticket::query()->createdToday()->count(),
            'week' => Ticket::query()->createdThisWeek()->count(),
            'month' => Ticket::query()->createdThisMonth()->count(),
        ];
    }

    public function paginateWithFilters(array $filters, int $perPage = 15): LengthAwarePaginator
    {
        $query = Ticket::query()->with('customer');

        return (new TicketListFilter($filters))
            ->apply($query)
            ->latest('id')
            ->paginate($perPage);
    }

    public function updateStatus(int $id, TicketStatus $status): bool
    {
        return Ticket::where('id', $id)->update(['status' => $status->value]) > 0;
    }
}
