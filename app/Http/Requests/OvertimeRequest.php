<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OvertimeRequest extends FormRequest
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
            'title' => "required",
            'slug' => "required",
            'description' => "required",
            'rate_amount_hours' => "required|numeric",
            'work_hours' => "required",
            'employee_id' => "required",
            'date' => "required",
            'total_amount' => "required|numeric"
        ];
    }
}
