<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateHouseworkOrderRequest;
use App\Http\Resources\HouseworkOrderResource;
use App\Models\HouseworkOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HouseworkOrderController extends Controller
{
    /**
     * 家事の表示順を更新する。
     *
     * @param  \App\Http\Requests\UpdateHouseworkOrderRequest  $request
     * @return HouseworkOrderResource
     */
    public function update(UpdateHouseworkOrderRequest $request)
    {
        $houseworkOrder = DB::transaction(function () use ($request) {
            $user = Auth::user();
            $houseworkOrder = HouseworkOrder::findOrFail($user->id);

            $houseworkOrder->user_id = $user->id;
            $houseworkOrder->order = $request['order'];
            $houseworkOrder->save();

            return $houseworkOrder;
        });
        return new HouseworkOrderResource($houseworkOrder);
    }
}
