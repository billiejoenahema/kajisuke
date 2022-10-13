<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\InvokableRule;

class PostalCode implements InvokableRule
{
    /**
     * 郵便番号かどうか（0000-000形式）
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (!preg_match("/^[0-9]{3}-[0-9]{4}$/", $value)) {
            $fail(':attributeは正しい形式で指定してください。');
        }
    }
}
