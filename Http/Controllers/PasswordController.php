<?php

namespace Ignite\Users\Http\Controllers;

use Auth;
use Hash;
use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Users\Repositories\Traits\UpdateUserTrait;
use Illuminate\Http\Request;
use Ignite\Users\Http\Requests\ManagePasswordRequest;

class PasswordController extends AdminBaseController
{
    use UpdateUserTrait;

    /**
    * Constructor
    *
    */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Manage user passwords. User must be logged in
     */
    public function index()
    {
        return view('users::password_management');
    }

    /**
     * update a user's password.
     *
     * @param ManagePasswordRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ManagePasswordRequest $request)
    {
        $user = Auth::user();
        // check if old password checks out
        $old_password = $request->old_password;
        $new_password = $request->new_password;
        $new_password_confirmation = $request->new_password_confirmation;

        // ascertain that the old password is indeed the correct one
        if (! Hash::check($old_password, $user->password)) {
            // The passwords does not match
            flash()->error('The password you entered does not match your old password.');
            return redirect()->back();
        }

        // ascertain that the new password entered is not the old password
        if (Hash::check($new_password, $user->password)) {
            flash()->error('The password you used matches your old password. Please provide a new one.');
            return redirect()->back();
        }

        // good for saving now
        $user->password = bcrypt($new_password);
        $user->enforce_password_reset = false;

        if ($user->save()) {
            // send email to user
            // dispatch(new SendPasswordChangedEmail($user));

            flash()->success('Your password has been changed successfully.');
            return redirect()->to('auth/logout');
        }

        flash()->error('An error occurred. Please try again.');
        return redirect()->back();
    }

    /**
     * hard reset a user's password
     *
     * @param int $user_id
     *
     * @return mixed
     */
    public function hardReset(int $id)
    {
        if($this->hardResetUserPassword(false, $id))
        {
            // TODO: launch an event to alert the user
        }

        flash()->success('Password set to 12345678');
        return redirect()->back();
    }

}
