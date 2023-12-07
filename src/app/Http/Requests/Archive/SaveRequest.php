<?php

declare(strict_types=1);

namespace App\Http\Requests\Archive;

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
            'date' => ['required', 'date', Rule::unique('archives')->ignore($this->housework_id)],
            'content' => 'required|string|max:200',
        ];
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     */
    public function attributes(): array
    {
        return [
            'date' => '完了日',
            'content' => '内容',
        ];
    }

    /**
     * バリーデーションのためにデータを準備
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'date' => mb_substr($this->date, 0, 10),
        ]);
    }
}
