<?php

namespace App\Modules\Ticket\Services;

use App\Modules\Ticket\Contracts\ITicketRepository;

class Service
{
    public function __construct(protected ITicketRepository $repo) {}
}
