<?php

namespace Ignite\Users\Http\Requests;

use Auth;
use Carbon\Carbon;
use Hash;
use Ignite\Users\Entities\User;
use Illuminate\Foundation\Http\FormRequest;
use Validator;

class CredentialsRequest extends FormRequest
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
        return array_merge([
            "user.current" => "sometimes|required_with:user.password",
            "user.password" => "sometimes|required_with:user.current"
        ], $this->dependants());
    }

    /*
     * Custom messages
     */
    public function messages()
    {
        return [
            "user.current.required_with" => "You must provide your current password",
            "user.password.required_with" => "You must provide a new password",
            "user.email.unique" => "That email address has already been taken",
            "user.username.unique" => "That username has already been taken",

            //Dependant Fields
            "dependant.first_name.required" => "The first name is required",
            "dependant.last_name.required" => "The last name is required",
            "dependant.relationship.required" => "The relationship is required",
            "dependant.dob.required" => "The date of birth is required",
            "dependant.dob.before" => "The date of birth must be before present day",
        ];
    }

    /*
     * Extra validation
     */
    public function withValidator($validator)
    {
        // Validate password - check against password repetition and confirmed password
        $validator->after(function ($validator) {

            $user = auth()->user();

            if (isset($this->user["current"]) and ! Hash::check($this->user["current"], $user->password) )
            {
                $validator->errors()->add('user.current', 'The password you entered does not match your old password.');
            }
            if (isset($this->user["password"]) and Hash::check($this->user["password"], $user->password))
            {
                $validator->errors()->add('user.current', 'Your new password should not match your old password.');
            }

            // if request has username and confirm_username also, ascertain it is unique
            if(isset($validator->attributes()['user']['username']) and isset($validator->attributes()['user']['confirm_username']))
            {
                $unique = User::where('username', $validator->attributes()['user']['username'])->first();
                if($unique) {
                    $validator->errors()->add('user.username', 'The username has already been taken.');
                }
            }

            // if request has email and confirm_email also, ascertain it is unique
            if(isset($validator->attributes()['user']['email']) and isset($validator->attributes()['user']['confirm_email']))
            {
                $unique = User::where('email', $validator->attributes()['user']['email'])->first();
                if($unique) {
                    $validator->errors()->add('user.email', 'The email has already been taken.');
                }
            }

        });

        // validate dob for dependant and ensure max dependants allowed is not exceeded
        $validator->after(function ($validator)
        {
            if(isset($validator->attributes()['dependant']['dob']) and strtolower($validator->attributes()['dependant']['relationship']) <> 'spouse')
            {
                $dob = Carbon::parse($validator->attributes()['dependant']['dob'])->diff(Carbon::now());
                if($dob->y >= m_setting('users.max_age_of_dependant')) {
                    $validator->errors()->add('dependant.dob', 'The maximum age allowed for dependants is ' . m_setting('users.max_age_of_dependant'));
                }
            }

            if(isset($validator->attributes()['dependant']['first_name']))
            {
                $employee = User::find($this->user);

                if(count($employee->dependants) > m_setting('users.max_dependants_per_user')) {
                    $validator->errors()->add('dependant.max-number', 'The maximum number of dependants allowed per user has been reached! (' . m_setting('users.max_dependants_per_user') . ')');
                }
            }
        });
    }

    /**
     * Rules for dependants
     * @return array
     */
    public function dependants()
    {
        return [
            "dependant.first_name" => "sometimes|required",
            "dependant.last_name" => "sometimes|required",
            "dependant.relationship" => "sometimes|required",
            "dependant.dob" => 'sometimes|required|date',
            "dependant.gender" => 'sometimes|required',
        ];
    }
}
