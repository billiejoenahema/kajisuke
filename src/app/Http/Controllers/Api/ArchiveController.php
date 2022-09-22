<?php

namespace App\Http\Controllers\Api;

use App\Enums\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Archive\SaveRequest;
use App\Http\Resources\ArchiveResource;
use App\Models\Archive;
use App\Services\HouseworkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class ArchiveController extends Controller
{
    /**
     * 家事履歴一覧を取得する。
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $archives = Archive::all();

        return ArchiveResource::collection($archives);
    }

    /**
     * 家事の履歴を登録する。
     *
     * @param  SaveRequest  $request
     * @return JsonResponse
     */
    public function store(SaveRequest $request, HouseworkService $houseworkService): JsonResponse
    {
        $data = $request->all();
        DB::transaction(function () use ($data, $houseworkService) {
            $archive = Archive::create($data);
            $houseworkService->updateNextDate($archive);
        });

        return response()->json(['message', ResponseMessage::ARCHIVE_CERATED->value], Response::HTTP_CREATED);
    }

    /**
     * 家事履歴を更新する。
     *
     * @param  SaveRequest  $request
     * @param  Archive  $archive
     * @return JsonResponse
     */
    public function update(SaveRequest $request, Archive $archive): JsonResponse
    {
        $data = $request->all();
        DB::transaction(function () use ($data, $archive) {
            $archive->fill($data)->save();
        });

        return response()->json(['message', ResponseMessage::ARCHIVE_UPDATED->value], Response::HTTP_OK);
    }

    /**
     * 家事履歴を削除する。
     *
     * @param  Archive  $archive
     * @return JsonResponse
     */
    public function destroy(Archive $archive): JsonResponse
    {
        $archive->delete();

        return response()->json(['message', ResponseMessage::ARCHIVE_DELETED->value], Response::HTTP_NO_CONTENT);
    }
}
