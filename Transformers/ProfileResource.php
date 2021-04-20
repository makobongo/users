<?php

namespace Ignite\Users\Transformers;

use Illuminate\Http\Resources\Json\Resource;

class ProfileResource extends Resource
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
            'user_id'                       => $this->user_id,
            'roll_no'                       => $this->roll_no,
            'title'                         => $this->title,
            'first_name'                    => $this->first_name,
            'middle_name'                   => $this->middle_name,
            'last_name'                     => $this->last_name,
            'employee_category_id'          => $this->employee_category_id,
            'gender'                        => $this->gender,
            'dob'                           => $this->dob,
            'job_description'               => $this->job_description,
            'phone'                         => $this->phone,
            'photo'                         => $this->photo,
            'mpdb'                          => $this->mpdb,
            'pin'                           => $this->pin,
            'id_number'                     => $this->id_number,
            'staff_number'                  => $this->staff_number,
            'date_of_employment'            => $this->date_of_employment,
            'secondary_phone'               => $this->secondary_phone,
            'secondary_email'               => $this->secondary_email,
            'work_email'                    => $this->work_email,
            'address'                       => $this->address,
            'country'                       => $this->country,
            'county'                        => $this->county,
            'town'                          => $this->town,
            'district'                      => $this->district,
            'location'                      => $this->location,
            'coverphoto'                    => $this->coverphoto,
            'avatar'                        => $this->avatar,
            'notes'                         => $this->notes,
            'partner_institution'           => $this->partner_institution,
            'credit'                        => $this->credit,
    
            // dates
            'created_at'                    => eclair($this->created_at),
            'created_at_w3c'                => eclair($this->created_at, true, true),

        ];
    }
}
