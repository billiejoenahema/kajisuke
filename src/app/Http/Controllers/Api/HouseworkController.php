<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHouseworkRequest;
use App\Http\Requests\UpdateHouseworkRequest;
use App\Http\Resources\HouseworkResource;
use App\Models\Housework;
use App\Models\HouseworkOrder;
use App\Services\HouseworkService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HouseworkController extends Controller
{
    /**
     * 家事サービスインスタンス
     */
    protected $houseworkService;

    /**
     * インスタンスの生成
     *
     * @param  HouseworkService $houseworkService
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
        $order = HouseworkOrder::where('user_id', $user->id)->firstOr(function () {
            return null;
        });
        $query = Housework::with(['archives', 'category']);
        $houseworks = $query->where('user_id', $user->id)->when($order, function ($q) use ($order) {
            $q->orderByRaw("FIELD(id, $order)");
        })->get();
        return HouseworkResource::collection($houseworks);
    }

    /**
     * 家事を新規登録する。
     *
     * @param  \App\Http\Requests\StoreHouseworkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHouseworkRequest $request)
    {
        $housework = DB::transaction(function () use ($request) {
           $housework = Housework::create([
                'user_id' => Auth::user()->id,
                'title' => $request['title'],
                'comment' => $request['comment'],
                'cycle' => $request->getCycle(),
                'category_id' => $request->category_id,
            ]);
            $user = Auth::user();

            // すでに家事の表示順が設定されているかどうかを確認する
            $houseworkOrder = HouseworkOrder::where('user_id', $user->id)->firstOr(function () {
                return null;
            });
            // 設定されていなければ新規登録し、設定されていれば更新する
            if (empty($houseworkOrder)) {
                $houseworkOrder = HouseworkOrder::create([
                    'user_id' => $user->id,
                    'order' => $housework->id,
                ]);
            } else {
                $houseworkOrder->order = $houseworkOrder->order . ',' . (string) $housework->id;
                $houseworkOrder->save();
            }

            return $housework;
        });

        return new HouseworkResource($housework);
    }

    /**
     * 家事を更新する。
     *
     * @param  \App\Http\Requests\UpdateHouseworkRequest  $request
     * @param  \App\Models\Housework  $housework
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHouseworkRequest $request)
    {
        $housework = DB::transaction(function () use ($request) {
            $housework = Housework::findOrFail($request['id']);

            $housework->category_id = $request['category_id'];
            $housework->title = $request['title'];
            $housework->comment = $request['comment'];
            $housework->cycle = $request->getCycle();
            $housework->save();

            return $housework;
        });

        return new HouseworkResource($housework);
    }

    /**
     * 家事を削除する。
     *
     * @param  \App\Models\Housework  $housework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Housework $housework)
    {
        // 削除する
        // オーダーからこのIDを取り除く
    }
}
