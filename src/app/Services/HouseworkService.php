<?php

namespace App\Services;

use App\Models\Housework;
use Carbon\Carbon;

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
}
