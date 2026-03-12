<?php

namespace App\Modules\Ticket\Filters;

use App\Modules\Ticket\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Builder;

class TicketListFilter
{
    public function __construct(private array $filters) {}

    public function apply(Builder $query): Builder
    {
        return $query
            ->when(! empty($this->filters['date']), fn ($q) => $q->whereDate('created_at', $this->filters['date'])
            )
            ->when(
                isset($this->filters['status']) && TicketStatus::tryFrom($this->filters['status']) !== null,
                fn ($q) => $q->where('status', $this->filters['status'])
            )
            ->when(! empty($this->filters['email']) || ! empty($this->filters['phone']), fn ($q) => $q->whereHas('customer', fn ($q) => $q
                ->when(! empty($this->filters['email']), fn ($q) => $q->where('email', 'like', '%'.$this->filters['email'].'%')
                )
                ->when(! empty($this->filters['phone']), fn ($q) => $q->where('phone', 'like', '%'.$this->filters['phone'].'%')
                )
            )
            );
    }
}
