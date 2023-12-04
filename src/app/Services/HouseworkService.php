<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CycleUnit;
use App\Models\Housework;
use Carbon\Carbon;

class HouseworkService
{
    /**
     * 家事の次回実施日を更新する。
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
     */
    public function getNextDate($archiveDate, $cycle): object
    {
        return match ($cycle['unit']) {
            CycleUnit::DAY->value => Carbon::parse($archiveDate)->addDays($cycle['num']),
            CycleUnit::WEEK->value => Carbon::parse($archiveDate)->addWeeks($cycle['num']),
            CycleUnit::MONTH->value => Carbon::parse($archiveDate)->addMonths($cycle['num']),
            CycleUnit::YEAR->value => Carbon::parse($archiveDate)->addYears($cycle['num']),
            default => Carbon::parse($archiveDate)->addDays($cycle['num']),
        };
    }
}
