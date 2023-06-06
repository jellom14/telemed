<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddAppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|max:20', 'patient_id'=>'required|max:20', 
            'staff_id'=>'required|max:20', 'service_id'=>'required|max:100', 
            'mode_id'=>'required|max:20', 'date'=>'required|max:20', 
            'note'=>'required|max:20', 'Q1'=>'required|max:100', 
            'Q2'=>'required|max:20', 'Q3'=>'required|max:50', 
            'Q4'=>'required|max:20', 'Q5'=>'required|max:20',
            'Q6'=>'required|max:20', 'Q7'=>'required|max:20',
            'Q8'=>'required|max:20', 'Q9'=>'required|max:20',
            'Q10'=>'required|max:20', 'price'=>'required|max:20',
            'receipt_no'=>'required|max:20'
        ];
    }
}
