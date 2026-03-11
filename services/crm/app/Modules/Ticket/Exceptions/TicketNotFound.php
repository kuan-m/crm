<?php

namespace App\Modules\Ticket\Exceptions;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TicketNotFound extends NotFoundHttpException
{
    public function render(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
        ], Response::HTTP_NOT_FOUND);
    }
}
