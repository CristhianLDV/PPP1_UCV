<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveRequest extends FormRequest
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

    public function rules()
    {
        return [
        
            'emp_id' => 'required|exists:employees,id',
            'leave_date' => 'required|date',
            'concept' => 'nullable|integer',
            'status' => 'nullable|in:0,1,2',
    
        ]; 
    }
    
    public function messages()
    {
        return [
            'emp_id.required' => 'Debe seleccionar un empleado.',
            'leave_date.required' => 'Debe indicar la fecha del permiso.',
            'leave_date.date' => 'La fecha del permiso no es válida.',
            'concept.integer' => 'El concepto debe ser un número.',
            'status.in' => 'El estado debe ser 0 (pendiente), 1 (aprobado) o 2 (rechazado).',
        ];
    }
}
