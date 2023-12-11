<?php
namespace Modules\Admin\Transformers\Auth;
use Illuminate\Http\Resources\Json\JsonResource;


class PermissionTransformer extends JsonResource
{


    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'group' => $this->group,
            'group_name' => $this->group_name,
            'title' => $this->title,
            'guard_name' => $this->guard_name,
            'created_at' => $this->created_at->format('H:i d/m/Y'),
            'updated_at' => $this->updated_at->format('H:i d/m/Y'),
	        'urls' => [
		        'delete_url' => route('api.permissions.destroy', $this->id),
	        ],
        ];


        return $data;
    }

}
