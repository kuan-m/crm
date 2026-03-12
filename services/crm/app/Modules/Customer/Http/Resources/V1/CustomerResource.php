<?php

namespace App\Modules\Customer\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'CustomerResource',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'Иван Иванов'),
        new OA\Property(property: 'email', type: 'string', example: 'ivan@example.com'),
        new OA\Property(property: 'phone', type: 'string', example: '+79991234567'),
    ]
)]
/**
 * @mixin \App\Modules\Customer\Models\Customer
 */
class CustomerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var \App\Modules\Customer\Models\Customer $resource */
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'email' => $resource->email,
            'phone' => $resource->phone,
        ];
    }
}
