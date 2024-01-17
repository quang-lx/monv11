<?php

namespace Modules\Admin\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CreateDepartmentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'required',
                function ($attribute, $value, $fail) {
                    $name = strtolower($value);
                    $existingRecord = DB::table('department')
                        ->whereRaw("LOWER(name) = ?", [$name])
                        ->first();
    
                    if ($existingRecord) {
                        $fail('Tên nhóm đã tồn tại');
                    }
                },
            ],
        ];
    
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
        return [
            'name.required' => 'Thông tin này là bắt buộc',
            'name.unique' => 'Tên nhóm đã tồn tại'
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
