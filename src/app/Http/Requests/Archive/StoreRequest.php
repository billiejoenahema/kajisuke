<?php

namespace App\Http\Requests\Archive;

use App\Rules\UniqueDate;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'housework_id' => 'required|integer|exists:houseworks,id',
            'date' => ['required', 'date', new UniqueDate($this->housework_id)],
            'content' => 'required|string|max:200',
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
