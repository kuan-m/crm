<?php

namespace Tests\Feature;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class TestController extends Controller
{
    public function successWithNullData(): JsonResponse
    {
        // Проверяем, что null как data не ломает структуру
        return $this->success(null, 'Empty result');
    }

    public function successWithCustomCode(): JsonResponse
    {
        return $this->success(['id' => 1], 'Created', Response::HTTP_CREATED);
    }

    public function errorWithEmptyErrors(): JsonResponse
    {
        // errors не передан — должен вернуть пустой массив, не null
        return $this->error('Something failed');
    }

    public function errorWithNestedErrors(): JsonResponse
    {
        return $this->error('Validation failed', [
            'address.street' => ['Required.'],
        ], 422);
    }
}

class ControllerHelpersTest extends TestCase
{
    // success() с null в data не должен ронять структуру ответа
    public function test_success_with_null_data_preserves_structure(): void
    {
        Route::get('/api/test-null-data', [TestController::class, 'successWithNullData']);

        $this->getJson('/api/test-null-data')
            ->assertStatus(200)
            ->assertJsonStructure(['success', 'data', 'message'])
            ->assertJsonPath('data', null);
    }

    // success() пробрасывает кастомный HTTP-код (201)
    public function test_success_respects_custom_http_code(): void
    {
        Route::get('/api/test-created', [TestController::class, 'successWithCustomCode']);

        $this->getJson('/api/test-created')
            ->assertStatus(201)
            ->assertJsonPath('success', true);
    }

    // error() без errors возвращает пустой массив, не null и не отсутствующий ключ
    public function test_error_without_errors_returns_empty_array(): void
    {
        Route::get('/api/test-empty-errors', [TestController::class, 'errorWithEmptyErrors']);

        $this->getJson('/api/test-empty-errors')
            ->assertStatus(400)
            ->assertJsonPath('errors', []);
    }

    // error() корректно передаёт dot-notation ключи (nested validation errors)
    public function test_error_with_nested_dot_notation_errors(): void
    {
        Route::get('/api/test-nested-errors', [TestController::class, 'errorWithNestedErrors']);

        $this->getJson('/api/test-nested-errors')
            ->assertStatus(422)
            ->assertJson([
                'errors' => [
                    'address.street' => ['Required.'],
                ],
            ]);
    }
}
