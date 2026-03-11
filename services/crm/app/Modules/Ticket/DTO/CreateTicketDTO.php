<?php

namespace App\Modules\Ticket\DTO;

use App\Modules\Ticket\Enums\TicketStatus;

class CreateTicketDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $phone,
        public readonly string $email,
        public readonly string $subject,
        public readonly string $text,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            phone: $data['phone'],
            email: $data['email'],
            subject: $data['subject'],
            text: $data['text'],
        );
    }

    public function toTicketAttributes(int $customerId): array
    {
        return [
            'customer_id' => $customerId,
            'subject' => $this->subject,
            'text' => $this->text,
            'status' => TicketStatus::New,
        ];
    }
}
