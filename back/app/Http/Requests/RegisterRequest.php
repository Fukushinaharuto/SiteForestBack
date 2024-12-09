<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'そのメールアドレスは既に登録されています。',
            'password.required' => 'パスワードは必須です。',
            'password.confirmed' => 'パスワードが一致しません。',
            'password.min' => 'パスワードは8文字以上でなければなりません。',
            'password.mixedCase' => 'パスワードには大文字と小文字の両方を含める必要があります。',
            'password.numbers' => 'パスワードには少なくとも1つの数字が必要です。',
            'password.symbols' => 'パスワードには少なくとも1つの記号が必要です。',
            'password.uncompromised' => 'このパスワードは、過去に漏洩したことがあります。別のパスワードを使用してください。',
            
            
        ];
    }
}
