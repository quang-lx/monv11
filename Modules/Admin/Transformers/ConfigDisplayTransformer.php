<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class ConfigDisplayTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,


             'urls' => [
                'delete_url' => route('api.configdisplay.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
