<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class Katakana implements InvokableRule
{
    /**
     * カタカナかどうか（スペース、タブは許可する）
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!preg_match("/^([　 \t\r\n]|[ァ-ヶｦ-ﾟー])+$/u", $value)) {
            $fail(':attributeはカタカナで指定してください。');
        }
    }
}
