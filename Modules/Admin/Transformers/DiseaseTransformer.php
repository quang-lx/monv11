<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class DiseaseTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'describe' => $this->describe,
            'created_by'=> $this->created_by,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.disease.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
