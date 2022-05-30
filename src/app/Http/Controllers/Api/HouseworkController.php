<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHouseworkRequest;
use App\Http\Requests\UpdateHouseworkRequest;
use App\Http\Resources\HouseworkResource;
use App\Models\Housework;
use App\Models\HouseworkOrder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HouseworkController extends Controller
{
    /**
     * 家事一覧を取得する。
     *
     * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();
        $order = HouseworkOrder::where('user_id', $user->id)->first();
        $order = $order['order'] == 0 ? null : $order['order'];
        $query = Housework::with(['archives', 'category']);
        $houseworks = $query->where('user_id', $user->id)->when($order, function ($q) use ($order) {
            $q->orderByRaw("FIELD(id, $order)");
        })->get();
        return HouseworkResource::collection($houseworks);
    }

    /**
     * Store a newly created resource in storage.
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

            return $housework;
        });

        return new HouseworkResource($housework);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Housework  $housework
     * @return \Illuminate\Http\Response
     */
    public function show(Housework $housework)
    {
        //
    }

    /**
     * Update the specified resource in storage.
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
     * Remove the specified resource from storage.
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
