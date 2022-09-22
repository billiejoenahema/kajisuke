<?php

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
     *
     * @param  IndexRequest  $request
     * @return AnonymousResourceCollection
     */
    public function index(IndexRequest $request, Housework $housework): AnonymousResourceCollection
    {
        $user = Auth::user();
        $query = Housework::with(['archives', 'category'])->where('user_id', $user->id);
        $houseworks = $housework->sortByOrder($query, $request)->get();

        return HouseworkResource::collection($houseworks);
    }

    /**
     * 指定した家事を取得する。
     *
     * @param  Housework  $housework
     * @return HouseworkResource
     */
    public function show(Housework $housework): HouseworkResource
    {
        $housework->load(['archives', 'category']);

        return new HouseworkResource($housework);
    }

    /**
     * 家事を新規登録する。
     *
     * @param  SaveRequest  $request
     * @return JsonResponse
     */
    public function store(SaveRequest $request): JsonResponse
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        DB::transaction(function () use ($data) {
            Housework::create($data);
        });

        return response()->json(['message', ResponseMessage::HOUSEWORK_CERATED->value], Response::HTTP_CREATED);
    }

    /**
     * 家事を更新する。
     *
     * @param  SaveRequest  $request
     * @param  Housework  $housework
     * @return JsonResponse
     */
    public function update(SaveRequest $request, Housework $housework): JsonResponse
    {
        $data = $request->all();
        $housework->fill($data)->save();

        return response()->json(['message' => ResponseMessage::HOUSEWORK_UPDATED->value], Response::HTTP_OK);
    }

    /**
     * 家事を削除する。
     *
     * @param  Housework  $housework
     * @return JsonResponse
     */
    public function destroy(Housework $housework): JsonResponse
    {
        $housework->delete();

        return response()->json(['message' => ResponseMessage::HOUSEWORK_DELETED->value], Response::HTTP_OK);
    }
}
