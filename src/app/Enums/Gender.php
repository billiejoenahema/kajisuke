<?php

declare(strict_types=1);

namespace App\Enums;

enum Gender: int
{
    case NOT_KNOWN = 0;
    case MALE = 1;
    case FEMALE = 2;
    case NOT_APPLICABLE = 9;

    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return string
     */
    public function text(): string
    {
        return match ($this) {
            self::NOT_KNOWN => '不明',
            self::MALE => '男性',
            self::FEMALE => '女性',
            self::NOT_APPLICABLE => '適用不能',
        };
    }
}
