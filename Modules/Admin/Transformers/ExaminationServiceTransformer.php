<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class ExaminationServiceTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'code' => sprintf('DV%d', $this->id),
            'patient_id' => $this->patient_id,
            'examination_id'=> $this->examination_id,
            'service_id'=> $this->service_id,
            'from_source'=> $this->from_source,
            'source_text'=> $this->source_text,
            'status'=> $this->status,
            'status_text'=> $this->status_text,
            'status_color'=> $this->status_color,
            'pdf_link'=> $this->pdf_link,
            'created_by'=> $this->user,
            'created_by_name'=>$this->user? (optional($this->user)->username. ' - '. optional($this->user)->name): '',
            'result_by_info'=>$this->resultBy? (optional($this->resultBy)->username. ' - '. optional($this->resultBy)->name): '',

            'created_at'=> $this->created_at->format('H:i d/m/Y'),
            'updated_at'=> $this->updated_at,
            'service' => $this->testingService? (new TestingServiceTransformer($this->testingService)): [],

             'urls' => [
                'delete_url' => route('api.examinationservice.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
