<?php

namespace App\Http\Controllers\Api;

use App\Enums\ResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Category\SaveRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
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
     * @return CategoryResource
     */
    public function store(SaveRequest $request)
    {
        DB::transaction(function () use ($request) {
            Category::create([
                'user_id' => Auth::user()->id,
                'name' => $request['name'],
            ]);
        });
        return response()->json(['message', ResponseMessage::CATEGORY_CERATED->value], Response::HTTP_CREATED);
    }

    /**
     * カテゴリを更新する。
     *
     * @param  SaveRequest  $request
     * @return CategoryResource
     */
    public function update(SaveRequest $request)
    {
        DB::transaction(function () use ($request) {
            $category = Category::findOrFail($request['id']);

            $category->name = $request['name'];
            $category->save();
        });
        return response()->json(['message', ResponseMessage::CATEGORY_UPDATED->value], Response::HTTP_OK);
    }

    /**
     * カテゴリを削除する。
     *
     * @param  Int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Int $id)
    {
        $category = Category::findOrFail($id);
        $hasHousework = $category->houseworks->isNotEmpty();
        if ($hasHousework) {
            return response()->json(['message', ResponseMessage::CATEGORY_HAS_HOUSEWORK->value], Response::HTTP_BAD_REQUEST);
        }
        $category->delete();

        return response()->json(['message', ResponseMessage::CATEGORY_DELETED->value], Response::HTTP_OK);
    }
}
