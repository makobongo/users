<?php

/*
 * =============================================================================
 *
 * Collabmed Solutions Ltd
 * Project: Collabmed Health Platform
 * Author: Samuel Okoth <sodhiambo@collabmed.com>
 *
 * =============================================================================
 */

namespace Ignite\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest {

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        $this->rules = [
            //basics
            "first_name" => "required",
            "last_name" => "required",
            // "username" => "nullable|unique:users,username,NULL,username,parent,!0", // test this out
            "username" => "nullable",
            "dob" => "required|date",
            "id_number" => "numeric|digits_between:7,8|unique:users_user_profiles,id_number",
            "gender" => "required",
            //contacts
            //"mobile" => "required",
            "email" => "email|required|unique:users",
            "post_code" => "numeric",
            "town" => "required_with:address",
            // "roll_no" => "required|unique:users_user_profiles,roll_no,NULL,roll_no,roll_no,!0", // test this out
            "roll_no" => "required",
            "employee_category" => "required|exists:users_employee_categories,id",
        ];
        if ($this->has('dp_first_name')) {
            $this->rules["dp_first_name[]"] = "required";
            $this->rules["dp_last_name[]"] = "required";
            $this->rules["dp_gender[]"] = "required";
            $this->rules["dp_dob[]"] = "required|date";
            $this->rules["dp_relationship[]"] = "required";
            $this->rules["dp_photo[]"] = "image";
        }
        return $this->rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Format validation rules
     * @return array
     */
    public function messages() {
        return [];
    }

}
