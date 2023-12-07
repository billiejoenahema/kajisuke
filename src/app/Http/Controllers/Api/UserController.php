<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * ログインユーザー情報を取得する
     */
    public function __invoke(): UserResource
    {
        $user = Auth::user()->with('profile')->first();

        return new UserResource($user);
    }
}
