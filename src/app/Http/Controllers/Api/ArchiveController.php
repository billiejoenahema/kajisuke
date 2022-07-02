<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Archive\StoreRequest;
use App\Http\Requests\Archive\UpdateRequest;
use App\Http\Resources\ArchiveResource;
use App\Models\Archive;
use App\Services\HouseworkService;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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
     * @return Response
     */
    public function store(StoreRequest $request, HouseworkService $houseworkService): Response
    {
        DB::transaction(function () use ($request, $houseworkService) {
            $archive = Archive::create([
                'housework_id' => $request['housework_id'],
                'date' => $request->convertDate(),
                'content' => $request['content'],
            ]);
            $houseworkService->updateNextDate($archive);
        });
        return response()->json(config('const.ARCHIVE.CREATED'), Response::HTTP_CREATED);
    }

    /**
     * 家事履歴を更新する。
     *
     * @param  UpdateRequest  $request
     * @param  Archive  $archive
     * @return Response
     */
    public function update(UpdateRequest $request): Response
    {
        DB::transaction(function () use ($request) {
            $archive = Archive::findOrFail($request['id']);

            $archive->housework_id = $request['housework_id'];
            $archive->date = $request['date'];
            $archive->content = $request['content'];
            $archive->save();
        });
        return response()->json(config('const.ARCHIVE.UPDATED'), Response::HTTP_OK);
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
