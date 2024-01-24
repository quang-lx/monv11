<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class BoxTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'area_id' => $this->area_id,
            'name' => $this->name,
            'code' => $this->code,
            'status' => $this->status,
            'note' => $this->note,
            'status_text' => $this->status_text,


             'urls' => [
                'delete_url' => route('api.box.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
