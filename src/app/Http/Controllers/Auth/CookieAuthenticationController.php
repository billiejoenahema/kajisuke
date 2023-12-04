<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CookieAuthenticationController extends Controller
{
    /**
     * CookieAuthenticationController constructor.
     */
    public function __construct(
        private Auth $auth,
    ) {
    }

    /**
     * @throws Exception
     */
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required',
        ]);

        if ($this->getGuard()->attempt($credentials)) {
            $request->session()->regenerate();

            return new JsonResponse(['message' => 'ログインしました']);
        }

        throw new Exception('ログインに失敗しました。再度お試しください');
    }

    public function logout(Request $request): JsonResponse
    {
        $this->getGuard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new JsonResponse(['message' => 'ログアウトしました']);
    }

    private function getGuard(): Guard
    {
        return $this->auth->guard(config('auth.defaults.guard'));
    }
}
