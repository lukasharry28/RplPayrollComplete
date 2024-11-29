<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TunjanganRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'rate_amount' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul tunjangan wajib diisi.',
            'rate_amount.required' => 'Jumlah tunjangan wajib diisi.',
        ];
    }
}
