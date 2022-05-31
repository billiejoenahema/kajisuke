<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $categories = Category::with('houseworks')->where('user_id', $user->id)->get();
        return CategoryResource::collection($categories);
    }

    /**
     * カテゴリを登録する。
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $category = DB::transaction(function () use ($request) {
           $category = Category::create([
                'user_id' => Auth::user()->id,
                'name' => $request['name'],
            ]);

            return $category;
        });

        return new CategoryResource($category);
    }

    /**
     * カテゴリを更新する。
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request)
    {
        $category = DB::transaction(function () use ($request) {
            $category = Category::findOrFail($request['id']);

            $category->name = $request['name'];
            $category->save();

            return $category;
        });

        return new CategoryResource($category);
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
        if($hasHousework) {
            return response()->json(['message' => 'This category is in use and cannot be deleted'], 500);
        }
        $category->delete();
        return response()->json(['message' => 'Category deleted successfully'], 200);
    }
}
