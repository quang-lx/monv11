<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class ExaminationFullTransformer extends JsonResource
{


    public function toArray($request)
    {
        $user = optional($this->createdBy);

        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'status_text' => $this->status_text,
            'status_color' => $this->status_color,
            'started_at' => optional($this->started_at)->format('H:i d/m/Y'),
            'finished_at' => optional($this->finished_at)->format('H:i d/m/Y'),
            'diagnose' => $this->diagnose,
            'patient_id' => $this->patient_id,
            'type' => $this->type_text,
            'count_service' => $this->services->count(),
            'patient' => $this->patient? new PatientThinTransformer($this->patient): [],
            'created_by_info' => $user->name . ' - ' . $user->username,



        ];


        return $data;
    }


}
