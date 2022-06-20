<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Housework extends Model
{
    use HasFactory;

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

    const DAY = 1;
    const WEEK = 2;
    const MONTH = 3;
    const YEAR = 4;

    /**
     * 家事の次回実施日を返します。
     *
     * @param date $archiveDate
     * @param int $cycleUnit
     */
    public function getNextDate($archiveDate, $cycleUnit)
    {
        switch ($cycleUnit) {
            case Housework::DAY:
                return $archiveDate->addDay(Housework::DAY);
            case Housework::WEEK:
                return $archiveDate->addWeek(Housework::WEEK);
            case Housework::MONTH:
                return $archiveDate->addMonth(Housework::MONTH);
            case Housework::YEAR:
                return $archiveDate->addYear(Housework::YEAR);
        }
    }

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
     * @param  string|null $order
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function sortByHouseworkOrder($query, $order)
    {
        if (empty($order)) {
            return $query;
        }
        return $query->orderByRaw("FIELD(id, $order)");
    }
}
