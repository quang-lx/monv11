<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class BoxAreaTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,


            'urls' => [
                'delete_url' => route('api.boxarea.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
