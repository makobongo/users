<?php

namespace Ignite\Users\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'                            => (int) $this->id,
            'name'                          => $this->profile->full_name,
            'full_name'                     => $this->profile->full_name,
            
            // on the real though
            'username'                      => $this->username,
            'department_id'                 => $this->department_id,
            'is_employee'                   => $this->is_employee,
            'employment_type_id'            => $this->employment_type_id,
            'active'                        => $this->active,
            'last_login'                    => $this->last_login,
            'last_login_ip'                 => $this->last_login_ip,
            'device_id'                     => $this->device_id,
            
            // dates
            'email_verified_at'                 => eclair($this->email_verified_at),
            'email_verified_at_w3c'             => eclair($this->email_verified_at, true, true),
            'created_at'                        => eclair($this->created_at),
            'created_at_w3c'                    => eclair($this->created_at, true, true),
            
            // convenience
            'mobile'                        => optional($this->profile)->phone,
            'profile'                       => new ProfileResource($this->profile),
            'roles'                         => RoleResource::collection($this->roles),
            
            //
            'avatar_link'                   => ''
        ];
    }
}
