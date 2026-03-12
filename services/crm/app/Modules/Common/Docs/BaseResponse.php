<?php

namespace App\Modules\Common\Docs;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'BaseResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: true),
        new OA\Property(property: 'message', type: 'string', example: 'Операция выполнена успешно'),
    ],
    type: 'object'
)]
class BaseResponse {}
