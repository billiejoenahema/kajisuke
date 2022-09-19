<?php

namespace App\Http\Requests\Archive;

use App\Rules\UniqueDate;
use Illuminate\Foundation\Http\FormRequest;

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
            'date' => ['required', 'date', new UniqueDate($this->housework_id)],
            'content' => 'required|string|max:200',
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
            'date' => '完了日',
            'content' => '内容',
        ];
    }

    /**
     * 有効な実施日を返す。
     *
     * @return array
     */
    public function convertDate()
    {
        $date = $this->input('date');

        return substr($date, 0, 10);
    }
}
