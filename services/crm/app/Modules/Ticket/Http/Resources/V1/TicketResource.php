<?php

namespace App\Modules\Ticket\Http\Resources\V1;

use App\Modules\Customer\Http\Resources\V1\CustomerResource;
use App\Modules\File\Http\Resources\V1\FileResource;
use App\Modules\Ticket\Enums\TicketStatus;
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
        new OA\Property(property: 'customer', ref: '#/components/schemas/CustomerResource', nullable: true),
        new OA\Property(
            property: 'attachments',
            type: 'array',
            items: new OA\Items(ref: '#/components/schemas/FileResource'),
            nullable: true
        ),
    ]
)]
class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var \App\Modules\Ticket\Models\Ticket $this */
        $status = $this->status instanceof TicketStatus
            ? $this->status
            : TicketStatus::from($this->status);

        return [
            'id' => $this->id,
            'subject' => $this->subject,
            'text' => $this->text,
            'status' => $status->value,
            'status_label' => $status->label(),
            'created_at' => $this->created_at->toIso8601String(),
            'customer' => new CustomerResource($this->whenLoaded('customer')),
            'attachments' => FileResource::collection($this->whenLoaded('media')),
        ];
    }
}
