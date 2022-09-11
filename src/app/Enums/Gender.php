<?php

declare(strict_types=1);

namespace App\Enums;

enum Gender: int
{
    use CodeTrait;

    case NOT_KNOWN = 0;
    case MALE = 1;
    case FEMALE = 2;
    case NOT_APPLICABLE = 9;

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
