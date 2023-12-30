<?php

namespace Modules\Admin\Transformers;


use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;


class ExaminationServiceFullTransformer extends JsonResource
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
            'status_class'=> $this->status_class,
            'pdf_link'=> $this->pdf_link? sprintf('data:application/pdf;base64,%s', $this->pdf_link): null,
            'created_by'=> $this->user,
            'patient' => $this->patient? new PatientThinTransformer($this->patient): [],
            'created_by_name'=>$this->user? (optional($this->user)->username. ' - '. optional($this->user)->name): '',
            'result_by_info'=>$this->resultBy? (optional($this->resultBy)->username. ' - '. optional($this->resultBy)->name): '',
            'result_at' => $this->result_at? $this->result_at->format('H:i d/m/Y'): '',
            'ket_qua' => $this->ket_qua,
            'ket_luan' => $this->ket_luan,
            'created_at'=> $this->created_at->format('H:i d/m/Y'),
            'updated_at'=> $this->updated_at,
            'service' => $this->testingService? (new TestingServiceTransformer($this->testingService)): [],
            'list_index' => $this->listIndex?  ExaminationIndexTransformer::collection($this->listIndex): [],
            'examination_info' => $this->examination?  new ExaminationThinTransformer($this->examination): [],

             'urls' => [
                'delete_url' => route('api.examinationservice.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
