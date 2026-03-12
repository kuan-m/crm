<?php

namespace App\Modules\File\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'FileResource',
    properties: [
        new OA\Property(property: 'id', type: 'integer', example: 1),
        new OA\Property(property: 'name', type: 'string', example: 'invoice'),
        new OA\Property(property: 'file_name', type: 'string', example: 'invoice.pdf'),
        new OA\Property(property: 'mime_type', type: 'string', example: 'application/pdf'),
        new OA\Property(property: 'size', type: 'integer', example: 204800),
        new OA\Property(property: 'url', type: 'string', example: 'https://example.com/storage/1/invoice.pdf'),
    ]
)]
/**
 * @mixin \Spatie\MediaLibrary\MediaCollections\Models\Media
 */
class FileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var \Spatie\MediaLibrary\MediaCollections\Models\Media $resource */
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'file_name' => $resource->file_name,
            'mime_type' => $resource->mime_type,
            'size' => $resource->size,
            'url' => $resource->getUrl(),
        ];
    }
}
