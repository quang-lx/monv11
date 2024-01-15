<?php

namespace Modules\Admin\Http\Requests\Device;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDeviceRequest extends FormRequest
{
    public function rules()
    {
        $device = $this->route()->parameter('device');

        return [
            'code'=>"required|unique:device,code,{$device->id}",
            'name'=>"required",
            'medias_multi.device_collection.files' => 'array|max:5'

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
            'medias_multi.device_collection.files.max' => 'Tối đa 5 file'

        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
