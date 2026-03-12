<?php

namespace App\Modules\Ticket\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Modules\Ticket\Enums\TicketStatus;
use App\Modules\Ticket\Http\Requests\V1\UpdateStatusRequest;
use App\Modules\Ticket\Services\Service;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class StatusController extends Controller
{
    public function __construct(
        protected Service $ticketService
    ) {}

    #[OA\Patch(
        path: '/v1/tickets/{id}/status',
        summary: 'Обновить статус заявки',
        security: [['sanctum' => []]],
        tags: ['Tickets'],
        parameters: [
            new OA\Parameter(
                name: 'id',
                description: 'ID заявки',
                in: 'path',
                required: true,
                schema: new OA\Schema(type: 'integer')
            ),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(
                        property: 'status',
                        type: 'integer',
                        description: 'ID нового статуса (1 - Новая, 2 - В процессе, 3 - Обработана)',
                        enum: [1, 2, 3]
                    ),
                ]
            )
        ),
        responses: [
            new OA\Response(
                response: 200,
                description: 'Статус заявки успешно обновлен',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'data',
                            type: 'object',
                            properties: [
                                new OA\Property(property: 'replied_at', type: 'string', format: 'date-time', nullable: true, example: '2026-03-12T12:00:00Z'),
                            ]
                        ),
                        new OA\Property(property: 'message', type: 'string', example: 'Статус заявки обновлен'),
                    ]
                )
            ),
            new OA\Response(
                response: 422,
                description: 'Ошибка валидации',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse')
            ),
            new OA\Response(
                response: 404,
                description: 'Заявка не найдена',
                content: new OA\JsonContent(ref: '#/components/schemas/NotFoundResponse')
            ),
            new OA\Response(
                response: 401,
                description: 'Неавторизован',
                content: new OA\JsonContent(ref: '#/components/schemas/UnauthorizedResponse')
            ),
        ]
    )]
    public function __invoke(int $id, UpdateStatusRequest $request): JsonResponse
    {
        $status = TicketStatus::from($request->validated('status'));

        $repliedAt = $this->ticketService->changeStatus($id, $status);

        return $this->success(
            ['replied_at' => $repliedAt?->toIso8601String()],
            'Статус заявки обновлен'
        );
    }
}
