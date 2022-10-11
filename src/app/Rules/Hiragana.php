<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class Hiragana implements InvokableRule
{
    /**
     * ひらがなかどうか（スペース、タブは許可する）
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!preg_match("/^([　 \t\r\n]|[ぁ-ん]|[ー])+$/u", $value)) {
            $fail(':attributeはひらがなで指定してください。');
        }
    }
}
