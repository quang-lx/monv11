<?php

namespace Modules\Admin\Transformers;


use Illuminate\Http\Resources\Json\JsonResource;


class ExaminationIndexTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'ket_qua' => $this->ket_qua,
            'ket_luan' => $this->ket_luan,
            'index_data' => new ServiceIndexTransformer($this->indexModel),


             'urls' => [
                'delete_url' => route('api.examinationindex.destroy', $this->id),
            ],

        ];


        return $data;
    }


}
