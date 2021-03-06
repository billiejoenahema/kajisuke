<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Factory as Auth;

class CookieAuthenticationController extends Controller
{
    /**
     * CookieAuthenticationController constructor.
     * @param Auth $auth
     */
    public function __construct(
        private Auth $auth,
    ) {
    }

    /**
     * @param Request $request
     * @return JsonResponse
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

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->getGuard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return new JsonResponse(['message' => 'ログアウトしました']);
    }

    /**
     * @return StatefulGuard
     */
    private function getGuard(): StatefulGuard
    {
        return $this->auth->guard(config('auth.defaults.guard'));
    }
}
