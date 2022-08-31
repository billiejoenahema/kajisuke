<?php

namespace App\Services;

use App\Http\Requests\Housework\SaveRequest;
use App\Models\Housework;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HouseworkService
{
    /**
     * 家事の次回実施日を更新する。
     *
     * @param mixed $archive
     * @return void
     */
    public function updateNextDate($archive): void
    {
        $housework = Housework::findOrFail($archive->housework_id);
        $cycle = [
            'num' => $housework->cycle_num,
            'unit' => $housework->cycle_unit,
        ];
        $housework->next_date = self::getNextDate($archive->date, $cycle);

        $housework->save();
    }

    /**
     * 家事の次回実施日を返します。
     *
     * @param string $archiveDate
     * @param array $cycle
     *
     * @return object
     */
    public function getNextDate($archiveDate, $cycle): object
    {
        switch ($cycle['unit']) {
            case Housework::DAY['ID']:
                return Carbon::parse($archiveDate)->addDays($cycle['num']);
                break;
            case Housework::WEEK['ID']:
                return Carbon::parse($archiveDate)->addWeeks($cycle['num']);
                break;
            case Housework::MONTH['ID']:
                return Carbon::parse($archiveDate)->addMonths($cycle['num']);
                break;
            case Housework::YEAR['ID']:
                return Carbon::parse($archiveDate)->addYears($cycle['num']);
                break;
        }
    }

    /**
     * 家事を新規登録する。
     *
     * @param SaveRequest $request
     * @return Housework
     */
    public static function store(SaveRequest $request): Housework
    {
        $housework = DB::transaction(function () use ($request) {
            // 家事を新規登録する
            $housework = Housework::create([
                'user_id' => Auth::user()->id,
                'title' => $request['title'],
                'comment' => $request['comment'],
                'cycle_num' => $request['cycle_num'],
                'cycle_unit' => $request['cycle_unit'],
                'next_date' => $request->nextDate($request['next_date']),
                'category_id' => $request->category_id,
            ]);

            return $housework;
        });

        return $housework;
    }

    /**
     * 家事を更新する。
     *
     * @param StoreHouseworkRequest $request
     * @param Int $id
     * @return Housework
     */
    public static function update($request, Int $id): Housework
    {
        $housework = DB::transaction(function () use ($request, $id) {
            $housework = Housework::findOrFail($id);

            $housework->category_id = $request['category_id'];
            $housework->title = $request['title'];
            $housework->comment = $request['comment'];
            $housework->cycle_num = $request['cycle_num'];
            $housework->cycle_unit = $request['cycle_unit'];
            $housework->next_date = $request->nextDate($request['next_date']);
            $housework->save();

            return $housework;
        });
        return $housework;
    }

    /**
     * 家事を削除する。
     *
     * @param StoreHouseworkRequest $request
     * @return void
     */
    public static function destroy($id): void
    {
        DB::transaction(function () use ($id) {
            $housework = Housework::findOrFail($id);
            $housework->delete();
        });
    }
}
