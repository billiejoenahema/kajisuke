<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Housework\StoreRequest;
use App\Http\Requests\Housework\UpdateRequest;
use App\Http\Resources\HouseworkResource;
use App\Models\Housework;
use App\Models\HouseworkOrder;
use App\Services\HouseworkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

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
     * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();
        $query = Housework::with(['archives', 'category']);
        $houseworkOrder = HouseworkOrder::where('user_id', 1111111)->first();
        $order = $houseworkOrder ? $houseworkOrder->order : null;
        $houseworks = $query->where('user_id', $user->id)
            ->when($order, function ($q) use ($order) {
                $q->orderByRaw("FIELD(id, $order)");
            })->get();

        return HouseworkResource::collection($houseworks);
    }

    /**
     * 家事を新規登録する。
     *
     * @param  StoreHouseworkRequest $request
     * @return HouseworkResource
     */
    public function store(StoreRequest $request): HouseworkResource
    {
        $housework = $this->houseworkService->store($request);

        return new HouseworkResource($housework);
    }

    /**
     * 家事を更新する。
     *
     * @param  UpdateHouseworkRequest  $request
     * @return HouseworkResource
     */
    public function update(UpdateRequest $request): HouseworkResource
    {
        // 家事を更新する
        $housework = $this->houseworkService->update($request);

        return new HouseworkResource($housework);
    }

    /**
     * 家事を削除する。
     *
     * @param  Int  $id
     * @param  HouseworkService  $houseworkService
     * @return JsonResponse
     */
    public function destroy(Int $id): JsonResponse
    {
        $this->houseworkService->destroy($id);

        return response()->json(null, 204);
    }
}
