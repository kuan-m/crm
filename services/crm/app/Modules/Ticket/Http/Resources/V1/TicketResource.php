<?php

namespace App\Modules\Ticket\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'TicketResource',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'subject', type: 'string', example: 'Проблема с оплатой'),
        new OA\Property(property: 'text', type: 'string', example: 'Не могу оплатить заказ'),
        new OA\Property(property: 'status', ref: '#/components/schemas/TicketStatus'),
        new OA\Property(property: 'status_label', ref: '#/components/schemas/TicketStatusLabel'),
        new OA\Property(property: 'created_at', type: 'string', format: 'date-time'),
    ]
)]
class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'text' => $this->text,
            'status' => $this->status->value,
            'status_label' => $this->status->label(),
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
