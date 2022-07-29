<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

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
            'user_id' => 'required|integer|exists:users,id',
            'last_name' => 'nullable|string|max:50',
            'first_name' => 'nullable|string|max:50',
            'gender' => ['required', 'integer', ValidationRule::in([0, 1, 2, 9])],
            'birth' => 'nullable|string|size:10',
            'tel' => 'nullable|string|max:13',
            'zipcode1' => 'nullable|string|max:3',
            'zipcode2' => 'nullable|string|max:4',
            'prefecture' => ['nullable', 'string', ValidationRule::in(range(1, 47))],
            'city' => 'nullable|string|max:50',
            'street_address' => 'nullable|string|max:50',
        ];
    }
}
