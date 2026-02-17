<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
    return [
        'name' => 'required|string|max:255',
        'company_id' => 'required|exists:companies,id',
        'price' => 'required|integer|min:0',
        'stock' => 'required|integer|min:0',
        'comment' => 'nullable|string',
        'img_path' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
    return [
        'name.required' => '商品名は必須です',
        'company_id.required' => '企業名を選択してください',
        'price.required' => '価格は必須です',
        'stock.required' => '在庫数は必須です',
        'img_path.image' => '画像ファイルを選択してください',
        ];
    }

}
