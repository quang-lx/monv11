<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;


class VoucherTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'amount' => $this->amount,
            'type' => $this->type,
            'status' => $this->status,
            'range_time' => [$this->start_time, $this->end_time],
            'updated_at'=> $this->updated_at->format('d-m-Y'),
            'urls' => [
                'delete_url' => route('api.category.destroy', $this->id),
            ],

        ];


        return $data;
    }
}
