<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler
{
    public function __invoke(Throwable $e, $request): ?JsonResponse
    {
        if ($request->is('api/*') || $request->expectsJson()) {
            return match (true) {
                $e instanceof AuthenticationException => response()->json([
                    'success' => false,
                    'message' => 'Unauthorized Request.',
                ], Response::HTTP_UNAUTHORIZED),

                $e instanceof AuthorizationException => response()->json([
                    'success' => false,
                    'message' => 'Forbidden.',
                ], Response::HTTP_FORBIDDEN),

                $e instanceof ValidationException => response()->json([
                    'success' => false,
                    'message' => 'Validation failed.',
                    'errors' => $e->errors(),
                ], Response::HTTP_UNPROCESSABLE_ENTITY),

                $e instanceof TooManyRequestsHttpException => response()->json([
                    'success' => false,
                    'message' => 'Too many requests.',
                ], Response::HTTP_TOO_MANY_REQUESTS),

                $e instanceof NotFoundHttpException => response()->json([
                    'success' => false,
                    'message' => 'Resource not found.',
                ], Response::HTTP_NOT_FOUND),

                $e instanceof HttpException => response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], $e->getStatusCode()),

                $e instanceof RouteNotFoundException => response()->json([
                    'success' => false,
                    'message' => 'Route not found.',
                ], Response::HTTP_NOT_FOUND),

                default => response()->json([
                    'success' => false,
                    'message' => 'An unexpected error occurred.',
                    'details' => config('app.debug') ? $e->getMessage() : null,
                ], Response::HTTP_INTERNAL_SERVER_ERROR),
            };
        }

        return null; // Пусть Laravel обработает стандартно для web
    }
}
