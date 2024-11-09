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
            'name' => 'required',
            'description' => 'required|max:255',
            'image' => 'required|mimes:jpeg,png',
            'category' => 'required', /*categoryでいい？*/
            'status' => 'required', /*statusでいい？*/
            'price' => 'required|numeric|min:0'
        ];
    }

    public function messages(){
        return[
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '255文字以下で入力してください',
            'image.required' => '商品画像をアップロードしてください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'category.required' => '商品のカテゴリーを選択してください',
            'price.required' => '商品価格を入力してください',
            'price.numeric' => '数値で入力してください',
            'price.min' => '0円以上で入力してください',
        ];
    }
}
