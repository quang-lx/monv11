<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Mon\Entities\Patient;

class PatientFullTransformer extends JsonResource
{


    public function toArray($request)
    {
        $user = optional($this->user);

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'sex' => $this->sex,
            'sex_text' => $this->sex == 1 ? 'Nam' : 'Nữ',
            'birthday' => \DateTime::createFromFormat('Y-m-d H:i:s', $this->birthday)->format('Y-m-d'),
            'phone' => $this->phone,
            'email' => $this->email,
            'papers' => $this->papers,
            'job' => $this->job,
            'address' => $this->address,
            'dependant' => $this->dependant,
            'phone_dependant' => $this->phone_dependant,
            'data_sources' => $this->data_sources == Patient::Local ? 'Local' : 'LIS',

            'created_at' => $this->created_at->format('H:i d/m/Y'),
            'updated_at' => $this->updated_at->format('H:i d/m/Y'),
            'created_by_info' => $user->name . ' - ' . $user->username,
            'current_examination' => $this->current_examination? (new PatientExaminationTransformer($this->current_examination)): [],
            'diagnose' => optional($this->current_examination)->diagnose,

            'urls' => [
                'delete_url' => route('api.patient.destroy', $this->id),
            ],

        ];

        return $data;
    }





}
