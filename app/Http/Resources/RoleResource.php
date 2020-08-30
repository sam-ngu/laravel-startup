<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "guard_name" => $this->guard_name,
            "permission" => $this->permissions,
//            "user_num" => $this->users->count(),
            "created_at" => (string)$this->created_at,
            "updated_at" => (string)$this->updated_at,
        ];
    }
}
