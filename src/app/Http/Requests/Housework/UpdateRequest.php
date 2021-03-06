<?php

namespace App\Http\Requests\Housework;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'category_id' => 'required|integer|exists:categories,id',
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
            'comment' => '詳細',
            'cycle_num' => '実行周期数値',
            'cycle_unit' => '実行周期単位',
            'next_date' => '次回実行日',
            'category_id' => 'カテゴリID',
        ];
    }

    /**
     * 次回実施日を先頭から10文字切り出す。
     *
     * @params string $nextDate
     * @return string
     */
    public function nextDate($nextDate): string
    {
        return substr($nextDate, 0, 10);
    }
}
