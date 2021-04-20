<?php

namespace Ignite\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDependantRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'dependant.first_name' => 'required|max:25',
            'dependant.last_name' => 'required|max:25',
            'dependant.dob' => 'required|date',
            'dependant.gender' => 'required',
            'dependant.relationship' => 'required',
            // 'dp_photo' => 'image', // this is  a blob; not required
            'dependant.dob' => 'required',
        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}
