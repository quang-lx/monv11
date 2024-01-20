<?php

namespace Modules\Admin\Http\Requests\Excel;

use Illuminate\Foundation\Http\FormRequest;

class ExcelUploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file' => 'file|mimes:xlsx,xls|max:5120', // 5120 kilobytes = 5 megabytes
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [

        ];
    }
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [
            'file.mimes' => 'File không đúng định dạng. Vui lòng thử lại',
            'file.ends_with' => 'File không đúng định dạng. Vui lòng thử lại',
            'file.max' => 'Dung lượng file không được quá 20mb',
        ];
    }
}
