<?php

namespace Ignite\Users\Http\Controllers;

use Ignite\Users\Entities\User;
use Ignite\Users\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

// for mail
use Illuminate\Auth\Events\Registered;
// use Ignite\Users\Jobs\SendVerificationEmail;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('users::register');
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(Request $request)
    {
        app(UserRegistration::class)->register($request->all());
    }

    /**
     * Handle a registration request for the application.
     * overide the register() parent method and add two new lines, i.e dispatch() and return view
     * With this, the email is dispatched into queue and instead of directly loging that user, I
     * redirect to another page which will ask him to verify his email in order to continue
     *
     * @param \Ignite\Users\Http\Requests\RegisterRequestt $request
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user = $this->create($request);

        // launch an event
        event(new Registered($user));

        // dispatch a job to send a welcome email
        // dispatch(new SendVerificationEmail($user));

        flash('Your account was created. Please login');
        return redirect()->route('public.login');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $user = User::where('email_token', $token)->first();

        if($user) {
            $user->verified = 1;
            $user->email_token = null;

            if($user->save()) {
                flash('Your account was created. Please login');
                return redirect()->route('public.login');
            }
        }

        return redirect()->route('/')->withFail('An error occurred verifying your email.');
    }
}
