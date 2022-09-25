<?php

namespace App\Http\Controllers\Api;

use App\Enums\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\SaveRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    /**
     * カテゴリ一覧を取得する。
     *
     * @return CategoryResource
     */
    public function index(): AnonymousResourceCollection
    {
        $user = Auth::user();
        $categories = Category::with('houseworks')
            ->where('user_id', $user->id)->get();

        return CategoryResource::collection($categories);
    }

    /**
     * カテゴリを登録する。
     *
     * @param  SaveRequest  $request
     * @return JsonResponse
     */
    public function store(SaveRequest $request): JsonResponse
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        DB::transaction(function () use ($data) {
            Category::create($data);
        });

        return response()->json(['message' => ResponseMessage::CATEGORY_CERATED->value], Response::HTTP_CREATED);
    }

    /**
     * カテゴリを更新する。
     *
     * @param  SaveRequest  $request
     * @param  Category  $category
     * @return JsonResponse
     */
    public function update(SaveRequest $request, Category $category): JsonResponse
    {
        $data = $request->all();
        DB::transaction(function () use ($data, $category) {
            $category->fill($data)->save();
        });

        return response()->json(['message' => ResponseMessage::CATEGORY_UPDATED->value], Response::HTTP_OK);
    }

    /**
     * カテゴリを削除する。
     *
     * @param  Category  $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        // カテゴリに紐づく家事が存在する場合は削除しない
        if ($category->houseworks->isNotEmpty()) {
            return response()->json(['message' => ResponseMessage::CATEGORY_HAS_HOUSEWORK->value], Response::HTTP_BAD_REQUEST);
        }
        $category->delete();

        return response()->json(['message' => ResponseMessage::CATEGORY_DELETED->value], Response::HTTP_OK);
    }
}
