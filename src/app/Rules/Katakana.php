<?php

declare(strict_types=1);

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\InvokableRule;

class Katakana implements InvokableRule
{
    /**
     * カタカナかどうか（スペース、タブは許可する）
     *
     * @param string $attribute
     * @param Closure $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (! preg_match("/^([　 \t\r\n]|[ァ-ヶｦ-ﾟー])+$/u", $value)) {
            $fail(':attributeはカタカナで指定してください。');
        }
    }
}
