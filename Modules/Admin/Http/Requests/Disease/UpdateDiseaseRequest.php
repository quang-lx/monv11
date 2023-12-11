<?php

namespace Modules\Admin\Http\Requests\Disease;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiseaseRequest extends FormRequest
{
    
    public function rules()
    {
        $disease = $this->route()->parameter('disease');

        return [
            'code'=>"required|unique:disease,code,{$disease->id}",
            'name'=>"required",
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
            '*.required' => 'Thông tin này là bắt buộc',
            'code.unique' => 'Thông tin này đã tồn tại trên hệ thống',
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
