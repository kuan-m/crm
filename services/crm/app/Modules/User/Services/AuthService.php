<?php

namespace App\Modules\User\Services;

use App\Modules\User\Contracts\IAuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthService implements IAuthService
{
    public function attemptLogin(array $credentials, bool $remember = false): bool
    {
        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        return true;
    }

    public function logout(): void
    {
        Auth::logout();
    }
}
