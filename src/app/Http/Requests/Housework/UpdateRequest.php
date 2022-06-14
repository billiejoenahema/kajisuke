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
            'cycle_num' => 'required|string',
            'cycle_unit' => 'required|string',
        ];
    }

    public function getCycle()
    {
        $num = $this->input('cycle_num');
        $unit = $this->input('cycle_unit');
        return $num . ' ' . $unit;
    }
}
