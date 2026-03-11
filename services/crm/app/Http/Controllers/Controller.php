<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

#[OA\Info(
    title: 'CRM API',
    version: '1.0.0',
    description: 'API документация'
)]
#[OA\Server(
    url: '/api',
    description: 'Главный API сервер'
)]

// --- Общие схемы ответов ---

#[OA\Schema(
    schema: 'ValidationErrorResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Validation failed.'),
        new OA\Property(
            property: 'errors',
            type: 'object',
            example: ['email' => ['Введите корректный адрес электронной почты.']],
            additionalProperties: new OA\AdditionalProperties(
                type: 'array',
                items: new OA\Items(type: 'string')
            )
        ),
    ]
)]

#[OA\Schema(
    schema: 'TooManyRequestsResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Too many requests.'),
    ]
)]

#[OA\Schema(
    schema: 'NotFoundResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Resource not found.'),
    ]
)]

#[OA\Schema(
    schema: 'UnauthorizedResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Unauthorized Request.'),
    ]
)]

#[OA\Schema(
    schema: 'ForbiddenResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'Forbidden.'),
    ]
)]

#[OA\Schema(
    schema: 'ServerErrorResponse',
    properties: [
        new OA\Property(property: 'success', type: 'boolean', example: false),
        new OA\Property(property: 'message', type: 'string', example: 'An unexpected error occurred.'),
        new OA\Property(property: 'details', type: 'string', nullable: true, example: null),
    ]
)]

abstract class Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Handle a successful response.
     *
     * @param  mixed  $result
     */
    public function success($result, string $message, int $code = Response::HTTP_OK): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    /**
     * Handle an error response.
     */
    public function error(string $errorMessage, array $errors = [], int $code = Response::HTTP_BAD_REQUEST): JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $errorMessage,
            'errors' => $errors,
        ];

        return response()->json($response, $code);
    }
}
