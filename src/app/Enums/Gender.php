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
