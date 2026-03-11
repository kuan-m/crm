<?php

namespace Tests\Feature\Modules\Ticket;

use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Exceptions\TooManyTicketsException;
use App\Modules\Ticket\Services\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TooManyTicketsTest extends TestCase
{
    use RefreshDatabase;

    private Service $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(Service::class);
    }

    private function makeDTO(): CreateTicketDTO
    {
        return CreateTicketDTO::fromArray([
            'name' => 'Куанышбек Мыкыев',
            'phone' => '+79654444444',
            'email' => 'kuan@example.com',
            'subject' => 'Проблема с оплатой',
            'text' => 'Не могу оплатить заказ',
        ]);
    }

    public function test_first_ticket_created_successfully(): void
    {
        $ticket = $this->service->create($this->makeDTO());

        $this->assertDatabaseHas('tickets', [
            'id' => $ticket->id,
            'subject' => 'Проблема с оплатой',
        ]);
    }

    public function test_second_ticket_throws_too_many_tickets_exception(): void
    {
        $this->expectException(TooManyTicketsException::class);

        $dto = $this->makeDTO();

        $this->service->create($dto); // первый — ок
        $this->service->create($dto); // второй — исключение
    }
}
