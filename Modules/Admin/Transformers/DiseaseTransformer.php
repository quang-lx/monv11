<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class DiseaseTransformer extends JsonResource
{


    public function toArray($request)
    {
        $user = optional($this->user);

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'display_text' => $this->code.' - '. $this->name,
            'describe' => $this->describe,
            'created_by'=> $user->name . ' - ' . $user->username,
            'created_at' => $this->created_at->format('H:i d/m/Y'),
            'updated_at' => $this->updated_at->format('H:i d/m/Y'),
            'urls' => [
                'delete_url' => route('api.disease.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
