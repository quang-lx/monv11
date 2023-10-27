<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;


class PackagesTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'period_time' => $this->period_time,
            'status' => $this->status,
            'price' => $this->price,
            'updated_at'=> $this->updated_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.category.destroy', $this->id),
            ],

        ];


        return $data;
    }
}
