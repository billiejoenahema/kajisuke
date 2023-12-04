<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Housework
 *
 * @property int $id
 * @property int $user_id ユーザーID
 * @property int $category_id カテゴリ
 * @property string $title タイトル
 * @property string|null $comment コメント
 * @property int $cycle_num 実行周期数値
 * @property int $cycle_unit 実行周期単位
 * @property string $next_date 次回実施日
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Archive> $archives
 * @property-read int|null $archives_count
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\HouseworkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Housework newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Housework newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Housework query()
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereCycleNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereCycleUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereNextDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Housework whereUserId($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Archive> $archives
 *
 * @mixin \Eloquent
 */
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
     * @var array<string>
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
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 所有する履歴を取得する。
     */
    public function archives(): HasMany
    {
        return $this->hasMany(Archive::class)->orderBy('date', 'desc');
    }

    /**
     * 紐づくカテゴリを取得する。
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * 家事の表示順に従って家事一覧をソートする。
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function sortByOrder($query, $request)
    {
        if (empty($request['column'])) {
            return $query;
        }
        $sortValue = $request['column'];
        $sortDirection = $request->toDirection();

        return $query->orderBy($sortValue, $sortDirection);
    }

    /**
     * 家事の更新日時が新しい順にソートする。
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function sortByUpdatedAt($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * 家事の次回実施日が近い順にソートする。
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function sortByNextDate($query)
    {
        return $query->orderBy('next_date', 'asc');
    }
}
