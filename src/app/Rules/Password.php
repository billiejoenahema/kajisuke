<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\InvokableRule;

class Password implements InvokableRule
{
    /**
     * 半角英数記号のみかどうか
     *
     * @param string $attribute
     * @param Closure $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (! preg_match('/^[[:graph:]|[:space:]]+$/i', $value)) {
            $fail(':attributeは半角英数記号のみで指定してください。');
        }
    }
}
