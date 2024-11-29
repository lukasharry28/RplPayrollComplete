<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PayrollRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Sesuaikan dengan logika otorisasi
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required|string|regex:/^\d{2}-\d{2}-\d{4} \- \d{2}-\d{2}-\d{4}$/',
            // Format tanggal harus sesuai dengan "dd-mm-yyyy - dd-mm-yyyy"
        ];
    }

    /**
     * Get the custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'date.required' => 'Periode tanggal wajib diisi.',
            'date.regex' => 'Format periode tanggal tidak valid. Gunakan format "dd-mm-yyyy - dd-mm-yyyy".',
        ];
    }
}
