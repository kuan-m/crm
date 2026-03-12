<?php

namespace App\Modules\Ticket\Http\Controllers\V1;

use App\Modules\Ticket\Http\Controllers\BaseController;
use App\Modules\Ticket\Http\Resources\V1\StatisticsResource;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;

class StatisticsController extends BaseController
{
    #[OA\Get(
        path: '/v1/tickets/statistics',
        summary: 'Получить статистику заявок (сутки, неделя, месяц)',
        tags: ['Tickets'],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Статистика',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(property: 'data', ref: '#/components/schemas/StatisticsResource'),
                        new OA\Property(property: 'message', type: 'string', example: 'Статистика заявок'),
                    ]
                )
            ),
        ]
    )]
    public function __invoke(): JsonResponse
    {
        $stats = $this->service->getStatistics();

        return $this->success(
            new StatisticsResource($stats),
            'Статистика заявок'
        );
    }
}
