<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class DeviceTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'code' => $this->code,
            'type' => $this->type,
            'serial_number' => $this->serial_number,
            'note' => $this->note,
            'box' => $this->box,
            'status' => $this->status,
            'doc_no' => $this->doc_no,

             'urls' => [
                'delete_url' => route('api.device.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
