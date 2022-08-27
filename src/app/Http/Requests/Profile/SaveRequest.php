<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;

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
            'last_name' => 'nullable|string|max:50',
            'first_name' => 'nullable|string|max:50',
            'gender' => ['nullable', 'integer', ValidationRule::in([0, 1, 2, 9])],
            'birth' => 'nullable|string|size:10',
            'tel' => 'nullable|string|max:13',
            'zipcode1' => ['nullable', 'string', 'size:3', 'regex:/^[0-9]+$/'],
            'zipcode2' => ['nullable', 'string', 'size:4', 'regex:/^[0-9]+$/'],
            'prefecture' => ['nullable', 'string', ValidationRule::in(range(1, 47))],
            'city' => 'nullable|string|max:50',
            'street_address' => 'nullable|string|max:50',
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
            'last_name' => '苗字',
            'first_name' => '名前',
            'gender' => '性別',
            'birth' => '生年月日',
            'tel' => '電話番号',
            'zipcode1' => '郵便番号上3桁',
            'zipcode2' => '郵便番号下4桁',
            'prefecture' => '都道府県',
            'city' => '市区町村',
            'street_address' => '町丁目以下',
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'zipcode1.regex' => '郵便番号の上3桁は数字で入力してください',
            'zipcode2.regex' => '郵便番号の下4桁は数字で入力してください',
        ];
    }
}
