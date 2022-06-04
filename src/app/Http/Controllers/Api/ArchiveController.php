<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArchiveRequest;
use App\Http\Requests\UpdateArchiveRequest;
use App\Http\Resources\ArchiveResource;
use App\Models\Archive;
use Illuminate\Support\Facades\DB;

class ArchiveController extends Controller
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
     * 家事の履歴を登録する。
     *
     * @param  \App\Http\Requests\StoreArchiveRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArchiveRequest $request)
    {
        $archive = DB::transaction(function () use ($request) {
           $archive = Archive::create([
                'housework_id' => $request['housework_id'],
                'date' => $request['date'],
                'content' => $request['content'],
            ]);

            return $archive;
        });

        return new ArchiveResource($archive);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function show(Archive $archive)
    {
        //
    }

    /**
     * 家事履歴を更新する。
     *
     * @param  UpdateArchiveRequest  $request
     * @param  Archive  $archive
     * @return ArchiveResource
     */
    public function update(UpdateArchiveRequest $request)
    {
        $archive = DB::transaction(function () use ($request) {
            $archive = Archive::findOrFail($request['id']);

            $archive->housework_id = $request['housework_id'];
            $archive->date = $request['date'];
            $archive->content = $request['content'];
            $archive->save();

            return $archive;
        });
        return new ArchiveResource($archive);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archive $archive)
    {
        //
    }
}
