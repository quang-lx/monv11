<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class ServiceTypeTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'code' => $this->code,
            'name' => $this->name,
            'description' => $this->description,
            'created_at' => $this->created_at->format('H:i d/m/Y'),


             'urls' => [
                'delete_url' => route('api.servicetype.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
