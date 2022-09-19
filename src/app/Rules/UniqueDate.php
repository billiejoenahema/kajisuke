<?php

namespace App\Rules;

use App\Models\Archive;
use Illuminate\Contracts\Validation\Rule;

class UniqueDate implements Rule
{
    private $housework_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $housework_id)
    {
        $this->housework_id = $housework_id;
    }

    /**
     * 同日の家事履歴が存在するかどうかを確認する。
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $date = substr($value, 0, 10);

        return Archive::where('housework_id', $this->housework_id)->where('date', $date)->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '同じ日付の家事履歴が存在します。';
    }
}
