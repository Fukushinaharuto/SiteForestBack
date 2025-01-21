<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class PageRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
            ],
            'page' => [
                'required',
                'string',
                Rule::unique('pages', 'name')->where(function ($query) {
                    $project = Auth::user()->projects()->where('name', $this->input('name'))->first();
                    return $query->where('project_id', optional($project)->id);
                }),               
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'プロジェクト名は文字列で入力してください。',
            'name.string' => '文字列で入力してください。',
            'name.unique' => 'このページ名は既に使用されています。',
            'page.string' => 'ページ名は文字列で入力してください。',
            'page.unique' => 'このページ名は既にプロジェクト内で使用されています。',
        ];
    }
}
