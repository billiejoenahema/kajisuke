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
     * 次回実施日を先頭から10文字切り出す。
     *
     * @return string
     */
    public function nextDate(): string
    {
        return substr($this->input('next_date'), 0, 10);
    }
}
