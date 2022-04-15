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

class HouseworkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();
        $order = HouseworkOrder::where('user_id', $user->id)->first();
        $order = $order['order'];
        $query = Housework::with(['archives', 'categories']);
        $houseworks = $query->where('user_id', $user->id)->orderByRaw("FIELD(id, $order)")->get();

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
        //
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
    public function update(UpdateHouseworkRequest $request, Housework $housework)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Housework  $housework
     * @return \Illuminate\Http\Response
     */
    public function destroy(Housework $housework)
    {
        //
    }
}
