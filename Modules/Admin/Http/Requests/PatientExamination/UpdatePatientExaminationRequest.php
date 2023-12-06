<?php

namespace Modules\Admin\Http\Requests\PatientExamination;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientExaminationRequest extends FormRequest
{
    public function rules()
    {
        return [];
    }

    public function translationRules()
    {
        return [];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
