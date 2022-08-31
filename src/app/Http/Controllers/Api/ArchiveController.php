<?php

namespace App\Http\Controllers\Api;

use App\Enums\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Archive\SaveRequest;
use App\Models\Archive;
use App\Models\Housework;
use App\Services\HouseworkService;
use Illuminate\Support\Facades\DB;
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
        $user = auth()->user();
        $houseworks = Housework::where('user_id', $user->id)->get();
        $query = Archive::with('housework', 'housework.user');
        $archives = $query->whereIn('housework_id', $houseworks->pluck('id'))->get();

        return response()->json($archives);
    }

    /**
     * 家事の履歴を登録する。
     *
     * @param  SaveRequest  $request
     * @return Response
     */
    public function store(SaveRequest $request, HouseworkService $houseworkService): Response
    {
        DB::transaction(function () use ($request, $houseworkService) {
            $archive = Archive::create([
                'housework_id' => $request['housework_id'],
                'date' => $request->convertDate(),
                'content' => $request['content'],
            ]);
            $houseworkService->updateNextDate($archive);
        });
        return response()->json(['message', ResponseMessage::ARCHIVE_CERATED->value], Response::HTTP_CREATED);
    }

    /**
     * 家事履歴を更新する。
     *
     * @param  SaveRequest  $request
     * @param  Archive  $archive
     * @return Response
     */
    public function update(SaveRequest $request): Response
    {
        DB::transaction(function () use ($request) {
            $archive = Archive::findOrFail($request['id']);

            $archive->housework_id = $request['housework_id'];
            $archive->date = $request['date'];
            $archive->content = $request['content'];
            $archive->save();
        });
        return response()->json(['message', ResponseMessage::ARCHIVE_UPDATED->value], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Archive  $archive
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archive $archive)
    {
        $archive->delete();
        return response()->json(['message', ResponseMessage::ARCHIVE_DELETED->value], Response::HTTP_NO_CONTENT);
    }
}
