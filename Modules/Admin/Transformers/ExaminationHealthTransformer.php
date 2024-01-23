<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class ExaminationHealthTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'patient_id' => $this->patient_id,
            'examination_id' => $this->examination_id,
            'create_date' => $this->create_date,
            'height' => $this->height,
            'weight' => $this->weight,
            'spo2' => $this->spo2,
            'bmi' => $this->bmi,
            'blood_pressure' => $this->blood_pressure,
            'heart_beat' => $this->heart_beat,
            'note' => $this->note,
            'is_edit' => false,

             'urls' => [
                'delete_url' => route('api.examinationhealth.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
