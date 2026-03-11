<?php

namespace App\Modules\Ticket\Services;

use App\Modules\Customer\Contracts\ICustomerRepository;
use App\Modules\Ticket\Contracts\ITicketRepository;
use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Exceptions\TooManyTicketsException;
use App\Modules\Ticket\Models\Ticket;
use Illuminate\Support\Facades\DB;

class Service
{
    public function __construct(
        protected ITicketRepository $ticketRepo,
        protected ICustomerRepository $customerRepo,
    ) {}

    /**
     * @throws TooManyTicketsException
     */
    public function create(CreateTicketDTO $dto): Ticket
    {
        if ($this->ticketRepo->hasRecentTicket($dto->email, $dto->phone)) {
            throw new TooManyTicketsException(
                'Вы уже отправляли заявку сегодня. Попробуйте завтра'
            );
        }

        return DB::transaction(function () use ($dto): Ticket {
            $customer = $this->customerRepo->firstOrCreate(
                $dto->email,
                $dto->phone,
                $dto->name,
            );

            return $this->ticketRepo->create($customer->id, $dto);
        });
    }
}
