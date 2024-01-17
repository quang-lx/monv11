<?php

namespace Modules\Admin\Http\Requests\Department;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class UpdateDepartmentRequest extends FormRequest
{
    public function rules()
    {
        $department = $this->route()->parameter('department');
        return [
            'name' => [
                'required',
                function ($attribute, $value, $fail) use ($department) {
                    $name = strtolower($value);
                    $existingRecord = DB::table('department')
                        ->whereRaw("LOWER(name) = ?", [$name])
                        ->where('id', '!=', $department->id)
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
