<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class PostTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'option' => $this->option,
            'sex' => $this->sex,
            'sex_name' => $this->sex == 1 ? 'Nam' : 'Nữ',


            'urls' => [
                'delete_url' => route('api.post.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
