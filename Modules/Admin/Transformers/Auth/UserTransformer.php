<?php
namespace Modules\Admin\Transformers\Auth;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Mon\Entities\User;
use Illuminate\Support\Facades\Log;

class UserTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'thumbnail' => $this->thumbnail,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'sex' => $this->sex,
            'status_text' => $this->expired_at && Carbon::createFromFormat('Y-m-d H:i:s', $this->expired_at)->gt(Carbon::now()) ? 'Hoạt động' : 'Không hoạt động',
            'sex_text' => $this->sex == User::MALE ? 'Nam' : 'Nữ',
            'department_id' => $this->department_id,
            'identification' => $this->identification,
            'roles' => $this->roles,
            'birth_day' => $this->birth_day ? Carbon::parse($this->birth_day)->format('d/m/Y') : null,
            'active_at' => Carbon::parse($this->active_at)->format('d/m/Y'),
            'expired_at' => Carbon::parse($this->expired_at)->format('d/m/Y'),
            'created_at' =>  Carbon::parse($this->created_at)->format('H:i d/m/Y'),
            'updated_at' => Carbon::parse($this->updated_at)->format('H:i d/m/Y'),
            'created_by_name' => optional($this->createdBy)->name,
            'urls' => [
                'delete_url' => route('api.users.destroy', $this->id),
            ],
        ];


        return $data;
    }

}
