<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseRequest extends FormRequest
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
            'payment_method' => ['required'],
            'address' => ['required','string'],
        ];
    }

    public function messages(){
        return  [
        'payment_method.required' => 'お支払方法を選択してください',
        'address.required' => '住所を入力してください',
        'address.string' => '住所を正しい文字列で入力してください',
        ];
    }
}
