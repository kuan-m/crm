<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;

class ApiInfrastructureTest extends TestCase
{
    // Валидация с несколькими полями и несколькими ошибками на одно поле
    public function test_validation_error_with_multiple_fields_and_messages(): void
    {
        Route::get('/api/test-validation-multi', function () {
            throw ValidationException::withMessages([
                'email' => ['Required.', 'Must be a valid email.'],
                'name' => ['Required.'],
            ]);
        });

        $this->getJson('/api/test-validation-multi')
            ->assertStatus(422)
            ->assertJsonCount(2, 'errors.email')
            ->assertJsonPath('errors.name.0', 'Required.')
            ->assertJsonPath('success', false);
    }

    // Убеждаемся, что errors отсутствует или пуст — не выставляется лишних ключей
    public function test_404_does_not_expose_errors_key(): void
    {
        $this->getJson('/api/route-that-does-not-exist')
            ->assertStatus(404)
            ->assertJsonMissing(['errors'])
            ->assertJsonPath('success', false);
    }

    // HttpException с нестандартным кодом (403) корректно проксируется
    public function test_http_exception_preserves_custom_status_and_message(): void
    {
        Route::get('/api/test-http-exception', function () {
            throw new HttpException(403, 'Forbidden territory');
        });

        $this->getJson('/api/test-http-exception')
            ->assertStatus(403)
            ->assertJsonPath('message', 'Forbidden territory')
            ->assertJsonPath('success', false);
    }

    // Неожиданное исключение: details присутствует в debug-режиме, скрыт в prod
    public function test_generic_exception_hides_details_outside_debug(): void
    {
        Route::get('/api/test-exception', function () {
            throw new \RuntimeException('Internal detail');
        });

        $response = $this->getJson('/api/test-exception')->assertStatus(500);

        config('app.debug')
            ? $response->assertJsonPath('details', 'Internal detail')
            : $response->assertJsonMissing(['details']);
    }

    // Исключение вне /api/* не перехватывается обработчиком — ответ не JSON
    public function test_non_api_route_exception_is_not_handled_as_json(): void
    {
        Route::get('/test-web-exception', function () {
            throw new \Exception('Web error');
        });

        $this->get('/test-web-exception')
            ->assertHeader('Content-Type', 'text/html; charset=UTF-8');
    }

    // AuthenticationException возвращает 401, не 500 и не 403
    public function test_unauthenticated_returns_401_with_correct_shape(): void
    {
        Route::get('/api/test-auth', function () {
            throw new AuthenticationException;
        });

        $this->getJson('/api/test-auth')
            ->assertStatus(401)
            ->assertJsonStructure(['success', 'message'])
            ->assertJsonPath('success', false);
    }
}
