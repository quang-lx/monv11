<?php

namespace Modules\Admin\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class CreatePostRequest extends FormRequest
{
    public function rules()
    {
        return [
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
        ];
    }

    public function translationMessages()
    {
        return [];
    }
}
