<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StockRequest extends FormRequest
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
        return[
            'product.name' => 'required|min:5',
            'product.description' => 'required|max:255',
            'amount' => 'required|numeric',
            'product.price' => 'required|numeric',
            'product.category_id' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute não pode ser vazio.',
        ];
    }

    public function attributes()
    {
        return [
            'product.name' => 'nome',
            'product.description' => 'descrição',
            'amount' => 'quantidade',
            'product.price' => 'preço',
            'product.category_id' => 'categoria',
        ];
    }
}
