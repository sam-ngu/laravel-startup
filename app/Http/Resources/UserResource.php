<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'id' => data_get($this, 'id'),
            'first_name' => data_get($this, 'first_name'),
            'last_name' => data_get($this, 'last_name'),
            'full_name' => data_get($this, 'full_name'),
            'email' => data_get($this, 'email'),
            'avatar_type' => data_get($this, 'avatar_type'),
            'avatar_location' => data_get($this, 'avatar_location'),
            'active'=> (bool)data_get($this, 'active'),
            'confirmed_label' => (bool)data_get($this, 'confirmed_label'),
            'timezone' => (string)data_get($this, 'timezone'),
            'roles_label' => data_get($this, 'roles_label'),
            'permissions_label' => data_get($this, 'permissions_label'),
            'social_buttons' => data_get($this, 'social_buttons'),
            'last_login_at'=> (string)data_get($this, 'last_login_at'),
            'last_login_ip'=> (string)data_get($this, 'last_login_ip'),
            'updated_at' => (string)data_get($this, 'updated_at'),
            'deleted_at' => (string)data_get($this, 'deleted_at'),
        ];
    }
}
