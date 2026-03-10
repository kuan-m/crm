<?php

namespace App\Modules\Ticket\Http\Controllers\V1;

use App\Modules\Ticket\Http\Controllers\BaseController;
use App\Modules\Ticket\Http\Requests\V1\CreateRequest;
use OpenApi\Attributes as OA;

class CreateController extends BaseController
{
    #[OA\Post(
        path: '/v1/tickets',
        summary: 'Создать новую заявку',
        tags: ['Tickets'],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(ref: '#/components/schemas/CreateTicketRequest')
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Заявка успешно создана',
                content: new OA\JsonContent(
                    properties: [new OA\Property(property: 'message', type: 'string', example: 'Ticket created successfully')]
                )
            ),
            new OA\Response(response: 422, description: 'Ошибка валидации'),
        ]
    )]
    public function __invoke(CreateRequest $request) {}
}
