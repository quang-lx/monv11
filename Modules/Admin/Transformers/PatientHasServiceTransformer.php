<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class PatientHasServiceTransformer extends JsonResource
{


    public function toArray($request)
    {
        $user = optional($this->user);
        $data = [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'service_id' => $this->service_id,
            'code' => optional($this->testingService)->code,
            'name' => optional($this->testingService)->name,
            'status' => $this->status,
            'created_by' => $user->name.' - '.$user->username,

        ];


        return $data;
    }


}
