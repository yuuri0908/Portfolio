<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class Validation extends FormRequest
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
            'kanji_last_name' => ['required', 'regex:/^[一-龥]+$/u'], // 漢字
            'kanji_first_name' => ['required', 'regex:/^[一-龥]+$/u'], // 漢字
            'hiragana_last_name' => ['required', 'regex:/^[ぁ-んー]+$/u'], // ひらがな
            'hiragana_first_name' => ['required', 'regex:/^[ぁ-んー]+$/u'], // ひらがな
            'roman_last_name' => ['required', 'regex:/^[a-zA-Z]+$/'], // ローマ字
            'roman_first_name' => ['required', 'regex:/^[a-zA-Z]+$/'], // ローマ字
            'email' => ['required', 'string', 'email', 'max:255'],//メールアドレス
            'password' => ['required', 'string', 'min:8', 'confirmed'],//パスワード
            'phone'=>['numeric'],//電話番号
        ];
    }


    protected function failedValidation(Validator $validator)
    {
        $res = response()->json([
            'errors' => $validator->errors(),
            ],
            400);
        throw new HttpResponseException($res);
    }
    public function messages()
    {
        return [
            'kanji_last_name.regex' => 'The :attribute must contain only Kanji characters.',
            'kanji_first_name.regex' => 'The :attribute must contain only Kanji characters.',
            'hiragana_last_name.regex' => 'The :attribute must contain only Hiragana characters.',
            'hiragana_first_name.regex' => 'The :attribute must contain only Hiragana characters.',
        ];
    }

}

