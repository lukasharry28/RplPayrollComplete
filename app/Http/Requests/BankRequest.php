<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BankRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'bank_name' => 'required|string|max:255',
            'image_name' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'bank_name.required' => 'Nama bank wajib diisi.',
        ];
    }
}
