<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHouseworkOrderRequest;
use App\Http\Requests\UpdateHouseworkOrderRequest;
use App\Http\Resources\HouseworkOrderResource;
use App\Models\HouseworkOrder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HouseworkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHouseworkOrderRequest  $request
     * @return HouseworkOrderResource
     */
    public function store(StoreHouseworkOrderRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HouseworkOrder  $houseworkOrder
     * @return \Illuminate\Http\Response
     */
    public function show(HouseworkOrder $houseworkOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HouseworkOrder  $houseworkOrder
     * @return \Illuminate\Http\Response
     */
    public function destroy(HouseworkOrder $houseworkOrder)
    {
        //
    }
}
