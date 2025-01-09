<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ];
        if ($this->isMethod('post')) {
            $rules['name'][] = 'unique:projects,name';
        }
        if ($this->isMethod('patch')) {
            $rules['name'][] = 'unique:projects,name,' . $this->route('id');
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'プロジェクト名は文字列で入力してください。',
            'name.string' => '文字列で入力してください。',
            'name.unique' => 'このプロジェクト名は既に使用されています。',
            'description.string' => '説明は文字列で入力してください',
        ];
    }
}
