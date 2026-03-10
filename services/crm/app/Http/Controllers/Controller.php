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
