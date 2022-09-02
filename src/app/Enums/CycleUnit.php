<?php

declare(strict_types=1);

namespace App\Enums;

enum CycleUnit: int
{
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

    /**
     * @return array
     */
    public static function toArray()
    {
        return array_map(function (self $case) {
            return [
                'id' => $case->value,
                'name' => $case->text(),
            ];
        }, self::cases());
    }

    /**
     * コード値を元に対応するテキストを取得する
     *
     * @param string|int|null $value コード値
     * @return string|null
     */
    public static function textByCode($value)
    {
        if ($value === null) {
            return null;
        }

        return self::tryFrom($value)?->text();
    }
}
