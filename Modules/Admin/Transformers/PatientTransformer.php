<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class PatientTransformer extends JsonResource
{


    public function toArray($request)
    {
        $user = optional($this->user);

        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'sex' => $this->sex,
            'label_sex' => $this->sex == 1 ? 'Nam' : 'Nữ',
            'birthday' => $this->birthday,
            'phone' => $this->phone,
            'email' => $this->email,
            'papers' => $this->papers,
            'job' => $this->job,
            'address' => $this->address,
            'dependant' => $this->dependant,
            'phone_dependant' => $this->phone_dependant,
            'data_sources' => $this->data_sources,
            'status' => $this->status,
            'created_at' => $this->created_at->format('d-m-Y'),
            'updated_at' => $this->updated_at->format('d-m-Y'),
            'created_by_info' => $user->name . ' - ' . $user->username,
            'status_name' => $this->status,
            'urls' => [
                'delete_url' => route('api.patient.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
