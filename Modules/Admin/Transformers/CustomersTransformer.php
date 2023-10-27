<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class CustomersTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'phone' => $this->phone,
            'email' => $this->email,
            'password' => $this->password,
            'status' => $this->status,
            'updated_at' => $this->updated_at->format('d-m-Y'),

             'urls' => [
                'delete_url' => route('api.customers.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
