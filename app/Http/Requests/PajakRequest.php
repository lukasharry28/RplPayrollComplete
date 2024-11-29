<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PajakRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'tax_amount' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Nama pajak wajib diisi.',
            'tax_amount.required' => 'Besaran pajak wajib diisi.',
        ];
    }
}
