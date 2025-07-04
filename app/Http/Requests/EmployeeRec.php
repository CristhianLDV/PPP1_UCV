<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRec extends FormRequest
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
    $id = $this->route('employee'); // Esto devuelve el id de la ruta directamente


    return [
        'dni' => 'required|digits:8|unique:employees,dni,' . $id,
        'name' => 'required|string|min:3|max:64|regex:/^[a-zA-ZÀ-ÿ\s]+$/u',
        'position' => 'required|string|min:3|max:64|regex:/^[\pL\s\-]+$/u',
        'email' => 'required|email|unique:employees,email,' . $id,
        'telefono' => 'required|regex:/^9\d{8}$/',
    ];
}




}
