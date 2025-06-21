<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'avatar' => ['nullable','image','mimes:jpg,png'],
            'name' => ['nullable','string',],
            'postal_code' => ['nullable','string','max:8'],
            'prefecture' => ['nullable','string'],
            'city' => ['nullable','string'],
            'street' => ['nullable','string'],
            'building' => ['nullable','string'],
        ];
    }

    public function messages(){
        return [
        'avatar.image' => '画像のファイルを選択してください',
        'avatar.mimes' => '画像の拡張子は.jpgまたは.pngのみ対応しています',
        ];
    }
}
