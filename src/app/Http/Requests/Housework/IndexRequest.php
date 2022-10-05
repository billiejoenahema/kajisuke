<?php

namespace App\Http\Requests\Housework;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'column' => 'nullable|string|in:title,comment,cycle_unit,next_date',
            'is_ascending' => 'nullable|string',
        ];
    }

    /**
     * ソートの方向を取得する
     *
     * @return string
     */
    public function toDirection(): string
    {
        return $this->is_ascending === 'true' ? 'asc' : 'desc';
    }
}
