<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class PatientExaminationThinTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'status' => $this->status,
            'status_text' => $this->status_text,
            'status_color' => $this->status_color,
            'status_class' => $this->status_class,
            'from_source' => $this->from_source,
            'source_text' => $this->source_text,




        ];


        return $data;
    }


}
