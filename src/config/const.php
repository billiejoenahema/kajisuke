<?php

use App\Enums\CycleUnit;
use App\Enums\Gender;
use App\Enums\Prefecture;

return [
    'CYCLE_UNIT' => CycleUnit::toArray(),
    'GENDER' => Gender::toArray(),
    'PREFECTURES' => Prefecture::toArray(),
    'YEARS' => range(1940, date('Y')),
    'MONTHS' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12],
    'DAYS' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 10, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31],
    'MAX_LENGTHS' => [
        'housework_title' => 30,
        'housework_comment' => 200,
        'category_name' => 30,
        'archive_content' => 200,
    ],
];
