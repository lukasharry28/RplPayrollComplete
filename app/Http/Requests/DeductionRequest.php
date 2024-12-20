<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeductionRequest extends FormRequest
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

        // if ($this->method() == 'PUT')
        // {
        //     $name_rules = "required|unique:deductions,name,{$this->deduction->deduction_id}";
        // }
        // else
        // {
        //     $name_rules = "required|unique:deductions";
        // }
        return [
            'name.required' => 'Nama pengurangan wajib diisi.',
            'name.unique' => 'Nama pengurangan sudah digunakan.',
            'amount.required' => 'Jumlah wajib diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
        ];
    }
}
