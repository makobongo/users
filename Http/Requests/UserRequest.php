<?php

namespace Ignite\Users\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "profile.first_name" => "required|string|max:255",
            "profile.last_name" => "required|string|max:255",
            "profile.phone" => "required|unique:users_user_profiles,phone",
            "profile.id_number" => "required|unique:users_user_profiles,id_number",
            
            "basic.username" => "required|unique:users,username|string|max:255",
            "basic.password" => "required|confirmed|string|max:255",
            "basic.email" => "required|email|unique:users,email|string|max:255",
            
            "roles" => "required|array",
            "facilities" => "nullable|array",
        ];
    }

    /*
     * Custom messages
     */
    public function messages()
    {
        return [
            "profile.first_name.required" => "The first name is required",
            "profile.last_name.required" => "The last name is required",
            "profile.phone.required" => "The phone number is required",
            "profile.id_number.required" => "The ID number is required",
            
            "basic.username.required" => "The username is required",
            "basic.password.required" => "The password is required",
            "basic.email.required" => "The email is required",
            
            "roles.required" => "You must select a role",
            "roles.array" => "Roles must be passed as an array",
        ];
    }
}
