<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\InvokableRule;

class AlphanumericAndSymbol implements InvokableRule
{
    /**
     * 半角英数記号かどうか
     *
     * @param string $attribute
     * @param Closure $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (! preg_match('/^[!-~]+$/u', $value)) {
            $fail(':attributeは半角英数記号で指定してください。');
        }
    }
}
