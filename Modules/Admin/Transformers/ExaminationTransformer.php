<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Mon\Entities\ExaminationService;


class ExaminationTransformer extends JsonResource
{


    public function toArray($request)
    {
        $user = optional($this->createdBy);

        $data = [
            'id' => $this->id,
            'type' => $this->type,
            'type_text' => $this->type_text,
            'status' => $this->status,
            'status_text' => $this->status_text,
            'status_color' => $this->status_color,
            'status_class' => $this->status_class,
            'started_at' => optional($this->started_at)->format('H:i d/m/Y'),
            'created_at' => optional($this->created_at)->format('H:i d/m/Y'),
            'finished_at' =>  optional($this->finished_at)->format('H:i d/m/Y'),
            'diagnose' => $this->diagnose,
            'disease_id' => $this->disease_id,
            'patient_id' => $this->patient_id,
            'count_service_done' => $this->services->where('status', ExaminationService::STATUS_DONE)->count(),
            'count_service' => $this->services->count(),
            'patient' => $this->patient? new PatientThinTransformer($this->patient): [],
            'created_by_info' => $user->name . ' - ' . $user->username,



        ];


        return $data;
    }


}
