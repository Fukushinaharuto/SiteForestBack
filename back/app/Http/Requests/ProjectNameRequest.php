<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectNameRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:projects,name'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'プロジェクト名は必須です。',
            'name.string' => '文字列で入力してください。',
            'name.unique' => 'そのプロジェクト名は使用されています。',
            'description.string' => '文字列で入力してください。',
        ];
    }
}
