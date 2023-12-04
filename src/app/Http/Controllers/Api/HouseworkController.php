<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Enums\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Housework\IndexRequest;
use App\Http\Requests\Housework\SaveRequest;
use App\Http\Resources\HouseworkResource;
use App\Models\Housework;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class HouseworkController extends Controller
{
    /**
     * 家事一覧を取得する。
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $user = Auth::user();
        $housework = new Housework();
        $query = Housework::with(['archives', 'category']);
        $query->where('user_id', $user->id);
        $houseworks = $housework->sortByOrder($query, $request)->get();

        return HouseworkResource::collection($houseworks);
    }

    /**
     * 指定した家事を取得する。
     */
    public function show(Housework $housework): HouseworkResource
    {
        $housework->load(['archives', 'category']);

        return new HouseworkResource($housework);
    }

    /**
     * 家事を新規登録する。
     */
    public function store(SaveRequest $request): JsonResponse
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        DB::transaction(function () use ($data) {
            Housework::create($data);
        });

        return response()->json(['message' => ResponseMessage::HOUSEWORK_CERATED->value], Response::HTTP_CREATED);
    }

    /**
     * 家事を更新する。
     */
    public function update(SaveRequest $request, Housework $housework): JsonResponse
    {
        $data = $request->all();
        DB::transaction(function () use ($housework, $data) {
            $housework->fill($data)->save();
        });

        return response()->json(['message' => ResponseMessage::HOUSEWORK_UPDATED->value], Response::HTTP_OK);
    }

    /**
     * 家事を削除する。
     */
    public function destroy(Housework $housework): JsonResponse
    {
        $housework->delete();

        return response()->json(['message' => ResponseMessage::HOUSEWORK_DELETED->value], Response::HTTP_OK);
    }

    /**
     * 紐づくユーザーの名前だけを取得する。
     */
    public function name(Housework $housework): JsonResponse
    {
        $housework->load('user');

        return response()->json(['user_name' => $housework->user->name]);
    }
}
