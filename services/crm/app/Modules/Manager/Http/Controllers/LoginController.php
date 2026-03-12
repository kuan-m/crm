<?php

namespace App\Modules\Manager\Http\Controllers;

use App\Enums\RouteName;
use App\Enums\ViewName;
use App\Http\Controllers\Controller;
use App\Modules\Manager\Http\Requests\LoginRequest;
use App\Modules\User\Contracts\IAuthService;
use Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function __construct(
        protected IAuthService $authService
    ) {}

    public function showForm()
    {
        if (Auth::check()) {
            return redirect()->route(RouteName::DASHBOARD->value);
        }

        return view(ViewName::LOGIN->value);
    }

    public function login(LoginRequest $request)
    {
        $this->authService->attemptLogin(
            $request->validated(),
            $request->boolean('remember')
        );

        $request->session()->regenerate();

        return redirect()->intended(route(RouteName::DASHBOARD->value));
    }

    public function logout(Request $request)
    {
        $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route(RouteName::LOGIN->value);
    }
}
