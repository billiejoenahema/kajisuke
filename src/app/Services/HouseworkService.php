<?php

namespace App\Services;

class HouseworkService
{
    /**
     * 次回実施日を返す。
     *
     * @param String $cycle
     * @param DateTime $last_date
     * @return String
     */
    public static function getNextDate($cycle, $last_date)
    {
        $next_date = date('Y年m月d日', strtotime($last_date . $cycle));
        return $next_date;
    }

    /**
     * 実行周期を判読可能な文字列に変換して返す。
     *
     * @param String $cycle
     * @return String
     */
    public static function getCycleValue($cycle)
    {
        $explodedCycles = [];
        // $cycleをスペースを区切り文字で分割する。
        $explodedCycles = explode(' ', $cycle);
        $cycleNum = str_replace('+', '', $explodedCycles[0]);
        $cycleUnit = $explodedCycles[1];
        if ($cycleUnit == 'day') {
            $cycle_value = $cycleNum == '1' ? '毎日' : $cycleNum . '日に一度';
        } elseif ($cycleUnit == 'week') {
            $cycle_value = $cycleNum == '1' ? '毎週' : $cycleNum . '週に一度';
        } elseif ($cycleUnit == 'month') {
            $cycle_value = $cycleNum == '1' ? '毎月' : $cycleNum . 'ヶ月に一度';
        } elseif ($cycleUnit == 'year') {
            $cycle_value = $cycleNum == '1' ? '毎年' : $cycleNum . '年に一度';
        }
        return $cycle_value;
    }
}
