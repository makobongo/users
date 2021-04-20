<?php

namespace Ignite\Users\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class UserDetailedResource extends Resource
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
            'id'                        => $this->id,
            'name'                      => $this->profile->full_name,
            'full_name'                 => $this->profile->full_name,
            
            // TODO: finish up on attributes
            'profile'                   => null,
        ];
    }
}
