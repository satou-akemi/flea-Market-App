<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'message_text' => 'required|max:400',
            'add-image' => 'mimes:png,jpeg'
        ];
    }

    public function messages(){
        return [
            'message_text.required' => '本文を入力してください',
            'message_text.max' =>'400文字以内で入力してください',
            'add-image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
        ];
    }
}
