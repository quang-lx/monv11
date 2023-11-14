<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class ConfigDisplayTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,

            'table_name' => $this->table_name,
            'col_name' => $this->col_name,
            'position' => $this->position,
            'order' => $this->position,


             'urls' => [
                'delete_url' => route('api.configdisplay.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
