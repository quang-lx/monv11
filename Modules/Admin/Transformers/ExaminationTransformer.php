<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class ExaminationTransformer extends JsonResource
{


    public function toArray($request)
    {
        $user = optional($this->createdBy);

        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'status_text' => $this->status_text,
            'status_color' => $this->status_color,
            'started_at' => $this->started_at,
            'finished_at' => $this->finished_at,
            'diagnose' => $this->diagnose,
            'patient_id' => $this->patient_id,
            'count_service' => $this->services->count(),
            'patient' => $this->patient? new PatientThinTransformer($this->patient): [],
            'created_by_info' => $user->name . ' - ' . $user->username,



        ];


        return $data;
    }


}
