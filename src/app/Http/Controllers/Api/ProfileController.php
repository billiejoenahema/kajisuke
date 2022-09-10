<?php

namespace App\Http\Controllers\Api;

use App\Enums\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\SaveRequest;
use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
     * @param  SaveRequest  $request
     * @return Response
     */
    public function update(SaveRequest $request): Response
    {
        $data = $request->all();
        DB::transaction(function () use ($data) {
            $user = Auth::user();
            $profile = Profile::where('user_id', $user->id)->first();
            $profile->update($data);
        });
        return response()->json(['message' => ResponseMessage::PROFILE_UPDATED->value], Response::HTTP_OK);
    }

    /**
     * 自身のプロフィール画像を更新する
     *
     * @param  SaveRequest  $request
     * @return Response
     */
    public function updateImage(SaveRequest $request): Response
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        // 画像ファイルが存在しなければ処理を終了する
        if (empty($request->file())) {
            return
                response()->json(['message' => ResponseMessage::PROFILE_NO_IMAGE->value], Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }
        $image = $request->file('image');
        if ($profile->image) {
            Storage::disk('public')->delete($profile->image);
        }
        $path = Storage::disk('public')->put('/', $image);
        DB::transaction(function () use ($profile, $path) {
            $profile->image = $path;
            $profile->save();
        });
        return response()->json(['message' => ResponseMessage::PROFILE_UPDATED->value], Response::HTTP_OK);
    }
}
