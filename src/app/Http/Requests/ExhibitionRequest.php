<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => ['required','string'],
            'description' => ['required','max:255'],
            'image_path' => ['required','file','mimes:jpg,png'],
            'category_ids' => ['required', 'array'],
            'category_ids.*' => ['exists:categories,id'],
            'condition' => ['required'],
            'price' => ['required','integer','min:0'],
        ];
    }

    public function messages(){
        return [
            'name.required' => 'お名前を入力してください',
            'name.string' => 'お名前は文字列で入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' =>'商品説明は２５５文字以内で入力してください',
            'image_path.required' => '商品画像を選択してください',
            'image_path.file' => '商品画像は正しいファイル形式で選択してください',
            'image_path.mimes' => '商品画像はjpeg,png形式で選択してください',
            'category_ids.required' =>'カテゴリーを選択してください',
            'category_ids.*.exists' => '選択したカテゴリーが無効です',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'price.integer' => '商品価格は数字で入力してください',
            'price.min' => '商品価格は０円以上で入力してください',
        ];
    }
}
