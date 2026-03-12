<?php

namespace App\Modules\Ticket\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'StatisticsResource',
    properties: [
        new OA\Property(property: 'today', type: 'integer', example: 5),
        new OA\Property(property: 'week', type: 'integer', example: 25),
        new OA\Property(property: 'month', type: 'integer', example: 100),
    ]
)]
class StatisticsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'today' => $this->resource['today'],
            'week' => $this->resource['week'],
            'month' => $this->resource['month'],
        ];
    }
}
