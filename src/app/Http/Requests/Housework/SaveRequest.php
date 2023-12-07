<?php

declare(strict_types=1);

namespace App\Http\Requests\Housework;

use App\Enums\CycleUnit;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', Rule::notIn(['0']), 'exists:categories,id'],
            'title' => 'required|string|max:30',
            'comment' => 'required|string|max:200',
            'cycle_num' => 'required|integer|between:1,31',
            'cycle_unit' => ['required', 'integer', Rule::in(CycleUnit::values())],
            'next_date' => 'required|string',
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     */
    public function attributes(): array
    {
        return [
            'title' => '家事名',
            'comment' => '家事内容',
            'cycle_num' => '実行周期',
            'cycle_unit' => '実行周期単位',
            'next_date' => '次回実行日',
            'category_id' => 'カテゴリ',
        ];
    }

    /**
     * バリーデーションのためにデータを準備
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'next_date' => mb_substr($this->next_date, 0, 10),
        ]);
    }
}
