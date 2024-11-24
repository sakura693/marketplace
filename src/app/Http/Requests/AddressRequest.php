<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'postal_code' => 'required|regex:/^[0-9]{3}-[0-9]{4}$/', 
            /*regexを使用。
            ^[0-9]{3}：最初の3文字は数字
            -：次にハイフン
            [0-9]{4}$：その後に4文字の数字*/
            'address' => 'required',
            'building' => 'required',    
        ];
    }

    public function messages(){
        return[
            'postal_code.required' => '郵便番号を入力してください',
            'postal_code.regex' => "ハイフンありの８文字で記入してください",
            'address.required' => '住所を記入してください',
            'building.required' => '建物名を記入してください',
        ];
    }
}
