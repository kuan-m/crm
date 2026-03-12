<?php

namespace App\Modules\Ticket\Services;

use App\Modules\Customer\Contracts\ICustomerRepository;
use App\Modules\File\Services\Service as FileService;
use App\Modules\Ticket\Contracts\ITicketRepository;
use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Enums\TicketMediaCollection;
use App\Modules\Ticket\Enums\TicketStatus;
use App\Modules\Ticket\Exceptions\TicketNotFound;
use App\Modules\Ticket\Exceptions\TooManyTicketsException;
use App\Modules\Ticket\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Service
{
    public function __construct(
        protected ITicketRepository $ticketRepo,
        protected ICustomerRepository $customerRepo,
        protected FileService $fileService,
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

            $ticket = $this->ticketRepo->create($customer->id, $dto);

            return $ticket->setRelation('customer', $customer);
        });
    }

    /**
     * @return \Spatie\MediaLibrary\MediaCollections\Models\Media[]
     */
    public function attachFiles(int $ticketId, array $files): array
    {
        $ticket = $this->ticketRepo->findOrFail($ticketId);

        return $this->fileService->attach(
            $ticket,
            $files,
            TicketMediaCollection::ATTACHMENTS->value
        );
    }

    public function show(int $id): Ticket
    {
        return $this->ticketRepo->show($id);
    }

    public function getStatistics(): array
    {
        return $this->ticketRepo->getStatistics();
    }

    public function getList(array $filters): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return $this->ticketRepo->paginateWithFilters($filters);
    }

    public function changeStatus(int $id, TicketStatus $status): ?Carbon
    {
        [$updated, $repliedAt] = $this->ticketRepo->updateStatus($id, $status);

        if (! $updated) {
            throw new TicketNotFound('Заявка не найдена или статус не обновлен');
        }

        return $repliedAt;
    }
}
