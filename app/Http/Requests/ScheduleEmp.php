<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleEmp extends FormRequest
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
            'slug' => 'required|string|min:3|max:32|alpha_dash',
            'time_in' => 'required|date_format:H:i|before:time_out',
            'time_out' => 'required|date_format:H:i',
        ];
        
    }

    public function messages()
    {
        return [
            'slug.required' => 'El identificador (slug) es obligatorio.',
            'slug.alpha_dash' => 'El identificador solo puede contener letras, números, guiones y guiones bajos.',
            'time_in.required' => 'La hora de entrada es obligatoria.',
            'time_in.date_format' => 'La hora de entrada debe tener el formato HH:MM.',
            'time_in.before' => 'La hora de entrada debe ser anterior a la hora de salida.',
            'time_out.required' => 'La hora de salida es obligatoria.',
            'time_out.date_format' => 'La hora de salida debe tener el formato HH:MM.',
        ];
    }
}
