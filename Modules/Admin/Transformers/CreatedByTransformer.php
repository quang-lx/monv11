<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Mon\Entities\Patient;

class CreatedByTransformer extends JsonResource
{


    public function toArray($request)
    {

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,


        ];

        return $data;
    }


}
