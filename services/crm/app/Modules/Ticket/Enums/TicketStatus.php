<?php

namespace App\Modules\Ticket\Enums;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TicketStatus',
    type: 'integer',
    description: 'ID статуса: 1 - Новый, 2 - В работе, 3 - Обработан',
    enum: [1, 2, 3],
    example: 1
)]
#[OA\Schema(
    schema: 'TicketStatusLabel',
    type: 'string',
    description: 'Человекочитаемый статус',
    enum: ['Новый', 'В работе', 'Обработан'],
    example: 'Новый'
)]
enum TicketStatus: int
{
    case New = 1;
    case InProcess = 2;
    case Processed = 3;

    public function label(): string
    {
        return match ($this) {
            self::New => 'Новый',
            self::InProcess => 'В работе',
            self::Processed => 'Обработан',
        };
    }
}
