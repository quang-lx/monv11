<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class PatientExaminationTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'status_text' => $this->status_text,
            'status_color' => $this->status_color,
            'status_class' => $this->status_class,
            'started_at' => optional($this->started_at)->format('H:i d/m/Y'),
            'finished_at' => optional($this->finished_at)->format('H:i d/m/Y'),
            'diagnose' => $this->diagnose,
            'disease_id' => $this->disease_id,
            'patient_id' => $this->patient_id,
            'from_source' => $this->from_source,
            'source_text' => $this->source_text,
            'count_service' => $this->services->count()




        ];


        return $data;
    }



}
