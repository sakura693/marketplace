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
            'image' => 'nullable|mimes:jpeg,png',
            'name' => 'required',
            'email' => 'nullable',
            'postal_code' => 'required',
            'address' => 'required',
            'building' => 'required',
        ];
    }

    public function messages(){
        return[
            'image.mimes' => "「.png」または「.jpeg」形式でアップロードしてください",
            'name.required' => "お名前を入力してください",
            'postal_code.required' => "郵便番号を入力してくださいを入力してください",
            'address.required' => "住所を入力してください",
            'building.required' => "建物名を入力してください",
        ];
    }
}

