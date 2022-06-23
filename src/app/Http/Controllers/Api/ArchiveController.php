<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Archive\StoreRequest;
use App\Http\Requests\Archive\UpdateRequest;
use App\Http\Resources\ArchiveResource;
use App\Models\Archive;
use App\Services\HouseworkService;
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
     * @param  StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, HouseworkService $houseworkService)
    {
        $archive = DB::transaction(function () use ($request, $houseworkService) {
            $archive = Archive::create([
                'housework_id' => $request['housework_id'],
                'date' => $request->convertDate(),
                'content' => $request['content'],
            ]);
            $houseworkService->updateNextDate($archive);
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
     * @param  UpdateRequest  $request
     * @param  Archive  $archive
     * @return ArchiveResource
     */
    public function update(UpdateRequest $request)
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
