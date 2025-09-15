<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Laravel\Fortify\Http\Requests\LoginRequest as FortifyLoginRequest;

class LoginRequest extends FortifyLoginRequest
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
            'email' => ['email','required'],
            'password' => ['required','min:8']
        ];
    }

    public function messages(){
        return [
            'email.email' => 'メールアドレスを入力してください',
            'email.required'=> 'メールアドレスを入力してください',
            'password.required' => 'パスワードを入力してください',
            'password.min' =>'パスワードは８文字以上で入力してください',
        ];
    }
}
