<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfileController extends Controller
{
    /**
     * 自身のプロフィールを取得する
     *
     * @return ProfileResource
     */
    public function index(): ProfileResource
    {
        $user = Auth::user();

        return new ProfileResource($user->profile);
    }

    /**
     * 自身のプロフィールを更新する
     *
     * @param  UpdateRequest  $request
     * @return Response
     */
    public function update(UpdateRequest $request): Response
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $profile->update($request->all());
        return response()->json(config('const.PROFILE.UPDATED'), Response::HTTP_OK);
    }
}
