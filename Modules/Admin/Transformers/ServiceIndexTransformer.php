<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class ServiceIndexTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,

            'service_id' => $this->service_id,
            'code' => $this->code,
            'code_lis' => $this->code_lis,
            'name' => $this->name,
            'type' => $this->type,
            'min_value' => $this->min_value,
            'max_value' => $this->max_value,
            'ref_value' => $this->ref_value,
            'male_min_value' => $this->male_min_value,
            'male_max_value' => $this->male_max_value,
            'unit' => $this->unit,
            'female_min_value' => $this->female_min_value,
            'female_max_value' => $this->female_max_value,
             'urls' => [
                'delete_url' => route('api.serviceindex.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
