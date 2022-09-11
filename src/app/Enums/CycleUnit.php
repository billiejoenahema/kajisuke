<?php

declare(strict_types=1);

namespace App\Enums;

enum CycleUnit: int
{
    use CodeTrait;

    case DAY = 1;
    case WEEK = 2;
    case MONTH = 3;
    case YEAR = 4;

    /**
     * @return string
     */
    public function text(): string
    {
        return match ($this) {
            self::DAY => '日',
            self::WEEK => '週',
            self::MONTH => '月',
            self::YEAR => '年',
        };
    }
}
