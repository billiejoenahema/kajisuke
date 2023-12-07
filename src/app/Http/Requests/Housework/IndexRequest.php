<?php

declare(strict_types=1);

namespace App\Http\Requests\Housework;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
            'column' => 'nullable|string|in:title,comment,cycle_unit,next_date',
            'is_ascending' => 'nullable|string',
        ];
    }

    /**
     * ソートの方向を取得する
     */
    public function toDirection(): string
    {
        return $this->is_ascending === 'true' ? 'asc' : 'desc';
    }
}
