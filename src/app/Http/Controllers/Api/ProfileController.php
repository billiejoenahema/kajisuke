<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProfileResource;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * @return ProfileResource
     */
    public function __invoke(): ProfileResource
    {
        $user = Auth::user();
        return new ProfileResource($user);
    }
}
