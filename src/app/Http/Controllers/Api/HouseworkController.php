<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Housework\IndexRequest;
use App\Http\Requests\Housework\StoreRequest;
use App\Http\Requests\Housework\UpdateRequest;
use App\Http\Resources\HouseworkResource;
use App\Models\Housework;
use App\Services\HouseworkService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HouseworkController extends Controller
{
    /**
     * 家事サービスインスタンス
     *
     * @var \App\Services\HouseworkService
     */
    protected $houseworkService;

    /**
     * 新しいクラスインスタンスの生成
     *
     * @param  \App\Services\HouseworkService  $houseworkService
     * @return void
     */
    public function __construct(HouseworkService $houseworkService)
    {
        $this->houseworkService = $houseworkService;
    }

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
     * @return HouseworkResource
     */
    public function show(Housework $housework): HouseworkResource
    {
        return new HouseworkResource($housework);
    }

    /**
     * 家事を新規登録する。
     *
     * @param  StoreRequest $request
     * @return Response
     */
    public function store(StoreRequest $request): Response
    {
        $this->houseworkService->store($request);

        return response()->json(config('const.HOUSEWORK.CREATED'), Response::HTTP_CREATED);
    }

    /**
     * 家事を更新する。
     *
     * @param  UpdateHouseworkRequest  $request
     * @return Response
     */
    public function update(UpdateRequest $request, Int $id): Response
    {
        $this->houseworkService->update($request, $id);

        return response()->json(config('const.HOUSEWORK.UPDATED'), Response::HTTP_OK);
    }

    /**
     * 家事を削除する。
     *
     * @param  Int  $id
     * @param  HouseworkService  $houseworkService
     * @return Response
     */
    public function destroy(Int $id): Response
    {
        $this->houseworkService->destroy($id);

        return response()->json(config('const.HOUSEWORK.DELETED'), Response::HTTP_OK);
    }
}
