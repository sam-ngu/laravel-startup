<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
        $avatar_location = $this->avatar_location;

        return [
            'id' => data_get($this, 'id'),
            'name' => data_get($this, 'name'),
            'email' => data_get($this, 'email'),
            'two_fa_enabled' => $this->twoFactorAuthEnabled(),
            'avatar_type' => data_get($this, 'avatar_type'),
            'avatar_location' => ! ! $avatar_location ? Storage::url(data_get($this, 'avatar_location')) : null,
            'active' => (bool)data_get($this, 'active'),
            'confirmed' => (bool)data_get($this, 'confirmed'),
            'timezone' => (string)data_get($this, 'timezone'),
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'permissions' => data_get($this, 'permissions_label'),
            'social_buttons' => data_get($this, 'social_buttons'),
            'last_login_at' => (string)data_get($this, 'last_login_at'),
            'last_login_ip' => (string)data_get($this, 'last_login_ip'),
            'created_at' => (string)data_get($this, 'created_at'),
            'updated_at' => (string)data_get($this, 'updated_at'),
            'deleted_at' => (string)data_get($this, 'deleted_at'),
        ];
    }
}
