<?php

namespace App\Modules\Ticket\Http\Controllers\V1;

use App\Modules\Ticket\Http\Controllers\BaseController;
use App\Modules\Ticket\Http\Resources\V1\TicketResource;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class ShowController extends BaseController
{
    #[OA\Get(
        path: '/v1/tickets/{id}',
        summary: 'Просмотреть детали заявки',
        tags: ['Tickets'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Детали заявки',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/TicketResource'),
                        new OA\Property(property: 'message', type: 'string', example: 'Детали заявки'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Заявка не найдена'),
        ]
    )]
    public function __invoke(int $id): JsonResponse
    {
        $ticket = $this->service->show($id);

        return $this->success(
            new TicketResource($ticket),
            'Детали заявки'
        );
    }
}
