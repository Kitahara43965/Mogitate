<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ProductRequest extends FormRequest
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
        $rules = [
            'name' => ['required', 'max:255'],
            // 'price' => ['required','numeric','digits_between:0,10000'],
            // 'description' => ['required','max:120'],
            // 'selectedSeasons' => ['required','array'],
        ];

        if($this->input('preview_url')){
            $rules['image'] = ['nullable'];
        }else{
            $rules['image'] = ['required', 'image', 'mimes:jpeg,png'];
        }

        return $rules;
    }


    public function messages()
     {
        $messages = [
            'name.required' => '商品名を入力してください',
            'name.max' => '商品名を255字以内で入力してください',
            //'price.required' => '値段を入力してください',
            //'price.numeric' => '数値で入力してください',
            //'price.digits_between' => '0~10000円以内で入力してください',
            //'description.required' => '商品説明を入力してください',
            //'description.max' => '120字以内で入力してください',
            //'selectedSeasons.required' => '季節を選択してください',
            //'selectedSeasons.array' => '季節の誤ったデータ型が入力されています',
        ];

        if ($this->input('preview_url')) {
        }else{//
            $messages['image.required'] = '商品画像を登録してください';
            $messages['image.image'] = '商品画像を画像として登録できていません';
            $messages['image.mimes'] = '「.png」または「.jpeg」形式でアップロードしてください';
        }

        return $messages;

    }

}
