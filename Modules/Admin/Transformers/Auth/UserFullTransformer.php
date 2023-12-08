<?php
namespace Modules\Admin\Transformers\Auth;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\Transformers\DepartmentTransformer;
use Modules\Mon\Entities\User;

class UserFullTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'avatar_url' => url($this->avatar_url),
            'type' => $this->type,
            'status' => $this->status,
            'shop_id' => $this->shop_id,
            'phone' => $this->phone,
            'sex' => $this->sex,
            'sex_text' => $this->sex == User::MALE ? 'Nam' : 'Nữ',
            'active_at' => optional($this->active_at)->format('Y-m-d'),
            'expired_at' => optional($this->expired_at)->format('Y-m-d'),
            'birth_day' => optional($this->birth_day)->format('Y-m-d'),
            'department_id' => $this->department_id,
            'department' => $this->department? new DepartmentTransformer($this->department): [],

            'identification' => $this->identification,
            'thumbnail' => $this->thumbnail,
            'created_at' => optional($this->created_at)->format('H:i d/m/Y'),
            'updated_at' =>optional($this->updated_at)->format('H:i d/m/Y'),
            'roles' => $this->getCheckedRoles(),
             'urls' => [
                    'delete_url' => route('api.users.destroy', $this->id),
                ],
        ];


        return $data;
    }
    private function getCheckedRoles(){
        return $this->roles()->get()->pluck('id');
    }
}
