<?php

namespace App\Modules\User\Contracts;

interface IAuthService
{
    /**
     * @param  array{email: string, password: string}  $credentials
     */
    public function attemptLogin(array $credentials, bool $remember = false): bool;

    public function logout(): void;
}
