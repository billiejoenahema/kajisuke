<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return UserResource
     */
    public function __invoke(): UserResource
    {
        return new UserResource(Auth::user());
    }
}
