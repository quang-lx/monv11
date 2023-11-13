<?php
namespace Modules\Admin\Transformers\Auth;
use Illuminate\Http\Resources\Json\JsonResource;


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
	        'status_text' => $this->status_text,
	        'sex_text' => $this->sex_text,
	        'department_id' => $this->department_id,
	        'identification' => $this->identification,
            'roles' => $this->roles,
            'birth_day' => optional($this->birth_day)->format('d/m/Y'),
            'created_at' => optional($this->created_at)->format('H:i d/m/Y'),
            'updated_at' =>optional($this->updated_at)->format('H:i d/m/Y'),
            'createdBy' => new UserTransformer($this->createdBy),
            'urls' => [
                'delete_url' => route('api.users.destroy', $this->id),
            ],
        ];


        return $data;
    }

}
