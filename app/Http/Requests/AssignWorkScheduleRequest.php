<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignWorkScheduleRequest extends FormRequest
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
           'emp_id' => 'required|exists:employees,id',
            'schedule_id' => 'required|exists:schedules,id',
            'service_id' => 'required|exists:services,id',
            'work_date' => 'required|array',
            'work_date.*' => 'required|date',
        ];
    }
}
