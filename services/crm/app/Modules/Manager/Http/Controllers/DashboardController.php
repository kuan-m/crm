<?php

namespace App\Modules\Manager\Http\Controllers;

use App\Enums\ViewName;
use App\Http\Controllers\Controller;
use App\Modules\Manager\Http\Requests\GetTicketListRequest;
use App\Modules\Ticket\Enums\TicketStatus;
use App\Modules\Ticket\Services\Service;

class DashboardController extends Controller
{
    public function __construct(
        protected Service $ticketService
    ) {}

    public function index()
    {
        $statuses = TicketStatus::cases();

        return view(ViewName::DASHBOARD->value, compact('statuses'));
    }

    public function getTicketList(GetTicketListRequest $request)
    {
        $filters = $request->validated();
        $tickets = $this->ticketService->getList($filters);

        return view(ViewName::MANAGER_TICKETS_LIST->value, compact('tickets'));
    }
}
