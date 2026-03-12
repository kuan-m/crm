<?php

namespace App\Modules\Ticket\Http\Controllers\V1;

use App\Modules\File\Http\Requests\V1\UploadRequest;
use App\Modules\File\Http\Resources\V1\FileResource;
use App\Modules\Ticket\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;
use OpenApi\Attributes as OA;
use Symfony\Component\HttpFoundation\Response;

class UploadFileController extends BaseController
{
    #[OA\Post(
        path: '/v1/tickets/{ticket}/files',
        summary: 'Загрузить файлы к заявке',
        tags: ['Tickets'],
        parameters: [
            new OA\Parameter(name: 'ticket', in: 'path', required: true, schema: new OA\Schema(type: 'integer')),
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\MediaType(
                mediaType: 'multipart/form-data',
                schema: new OA\Schema(ref: '#/components/schemas/UploadFileRequest')
            )
        ),
        responses: [
            new OA\Response(
                response: 201,
                description: 'Файлы успешно загружены',
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: 'success', type: 'boolean', example: true),
                        new OA\Property(
                            property: 'data',
                            type: 'array',
                            items: new OA\Items(ref: '#/components/schemas/FileResource')
                        ),
                        new OA\Property(property: 'message', type: 'string', example: 'Файлы успешно загружены'),
                    ]
                )
            ),
            new OA\Response(response: 404, description: 'Заявка не найдена',
                content: new OA\JsonContent(ref: '#/components/schemas/NotFoundResponse')
            ),
            new OA\Response(response: 422, description: 'Ошибка валидации',
                content: new OA\JsonContent(ref: '#/components/schemas/ValidationErrorResponse')
            ),
        ]
    )]
    public function __invoke(UploadRequest $request, int $ticket): JsonResponse
    {
        $files = $this->service->attachFiles($ticket, $request->file('files'));

        return $this->success(
            FileResource::collection(collect($files)),
            'Файлы успешно загружены',
            Response::HTTP_CREATED,
        );
    }
}
