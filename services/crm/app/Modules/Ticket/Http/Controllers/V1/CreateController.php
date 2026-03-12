<?php

namespace App\Modules\Ticket\Http\Controllers\V1;

use App\Modules\Ticket\DTO\CreateTicketDTO;
use App\Modules\Ticket\Http\Controllers\BaseController;
use App\Modules\Ticket\Http\Requests\V1\CreateRequest;
use App\Modules\Ticket\Http\Resources\V1\TicketResource;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

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
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TicketResource'),
                        new OA\Property(property: 'message', type: 'string', example: 'Заявка успешно создана'),
                    ]
                )
            ),
            new OA\Response(response: 422, description: 'Ошибка валидации'),
            new OA\Response(response: 429, description: 'Слишком много заявок'),
        ]
    )]
    public function __invoke(CreateRequest $request): JsonResponse
    {
        $ticket = $this->service->create(
            CreateTicketDTO::fromArray($request->validated())
        );

        return $this->success(
            new TicketResource($ticket),
            'Заявка успешно создана',
            Response::HTTP_CREATED,
        );
    }
}
