<?php

namespace App\Services;

class HouseworkService
{
    public static function getNextDate($cycle, $last_date)
    {
        $next_date = date('Y年m月d日', strtotime($last_date . $cycle));
        return $next_date;
    }
}
