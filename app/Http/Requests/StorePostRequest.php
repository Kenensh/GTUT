<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // 允許所有用戶提交表單
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'content' => 'required|string|min:10',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => '文章標題不能為空',
            'title.min' => '文章標題至少需要3個字元',
            'title.max' => '文章標題不能超過255個字元',
            'content.required' => '文章內容不能為空',
            'content.min' => '文章內容至少需要10個字元',
        ];
    }
}
