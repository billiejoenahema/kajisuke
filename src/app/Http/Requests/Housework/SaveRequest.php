<?php

namespace App\Http\Requests\Housework;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category_id' => ['required', 'integer', Rule::notIn(['0']), 'exists:categories,id'],
            'title' => 'required|string|max:30',
            'comment' => 'required|string|max:200',
            'cycle_num' => 'required|integer',
            'cycle_unit' => 'required|integer',
            'next_date' => 'required|string',
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array
     */
    public function attributes()
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
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'next_date' => substr($this->next_date, 0, 10),
        ]);
    }
}
