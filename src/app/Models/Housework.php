<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Housework extends Model
{
    use HasFactory;

    /** 実行周期の単位が日 */
    public const DAY = [
        'ID' => 1,
        'EVERY_DAY' => '毎日',
    ];
    /** 実行周期の単位が週 */
    public const WEEK = [
        'ID' => 2,
        'EVERY_WEEK' => '毎週',
    ];
    /** 実行周期の単位が月 */
    public const MONTH = [
        'ID' => 3,
        'EVERY_MONTH' => '毎月',
    ];
    /** 実行周期の単位が年 */
    public const YEAR = [
        'ID' => 4,
        'EVERY_YEAR' => '毎年',
    ];

    /**
     * 複数代入可能な属性
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'comment',
        'cycle_num',
        'cycle_unit',
        'next_date',
    ];

    /**
     * 紐づくユーザーを取得する。
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 所有する履歴を取得する。
     */
    public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    /**
     * 紐づくカテゴリを取得する。
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 家事の表示順に従って家事一覧をソートする。
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  mixed $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function sortByOrder($query, $request)
    {
        if (empty($request['column'])) {
            return $this->sortByUpdatedAt($query);
        }
        $sortValue = $request['column'];
        $sortDirection = $request->toDirection();
        return $query->orderBy($sortValue, $sortDirection);
    }

    /**
     * 家事の更新日時が新しい順にソートする。
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string|null $order
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function sortByUpdatedAt($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }
}
