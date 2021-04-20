<?php

namespace Ignite\Users\Http\Controllers\Auth;

use Dervis\Traits\ThemesTrait;
use GuzzleHttp\Client;
use Ignite\Settings\Entities\Practice;
use Ignite\Users\Entities\User;
use Ignite\Users\Events\UserLoggedIn;
use Ignite\Users\Library\Traits\CacheRecursiveDataTrait;
use Ignite\Users\Library\Traits\PassportCustomsTrait;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers, ValidatesRequests, PassportCustomsTrait, CacheRecursiveDataTrait;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = 'users/clinic-select';
    // protected $redirectAfterLogout = '/';

    /**
     * @var Request hold original request
     */
    protected $originalRequest;
    
    protected $theme;
    use ThemesTrait;
    
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest', ['except' => 'logout']);
        $this->setupTheme();
    }

    /**
     * override $redirectTo after login
     *
     * @return string
     */
    public function redirectTo()
    {
        // return route('public.clinic.select');
        // return route('system.dashboard');
    }


    /*
     * Overwrite the default login in case 'email' is not required or 'name' is renamed to 'username'
     */
    public function username()
    {
        return 'username';
    }

    
    /**
     * Get the login validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            $this->username() => 'required',
            'password' => 'required|min:4',
        ];
    }

    
    /**
     * reset the request variables after an internal laravel request
     *
     * @param $request
     */
    public function resetRequestVariables($request)
    {
        request()->headers->set('host', sanitizeDomainUrl($request->root()));
        request()->headers->set('origin', $request->header('origin'));
        request()->headers->set('origin', $request->header('origin'));
        request()->headers->set('user-agent', $request->userAgent());
    
        request()->server->set('SERVER_NAME', "");
        request()->server->set('HTTP_HOST', sanitizeDomainUrl($request->root()));
        request()->server->set('SERVER_ADDR', $request->ip());
        request()->server->set('REMOTE_ADDR', $request->ip());
    }
    
    /**
     * Get the login validation error messages.
     *
     * @return array
     */
    protected function validationErrorMessages()
    {
        return [];
    }

    /**
     * Show the application's login form if the application has been deployed
     * If not then load deployer
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        // return view('users::login');
        return $this->generatePage('login', 'auth.login');
    }

    /**
     * login
     */
    public function authenticate(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());
        $this->originalRequest = $request;

        $requestOauth = Request::create('/oauth/token', 'POST', array_merge(mconfig('users.config.passport'), [
                'username' => $request->get($this->username()),
                'password' => $request->password,
            ])
        );
        
        $resp = app()->handle($requestOauth);
        
        if($resp)
        {
            $customs = json_decode($resp->getContent());
            
            // check for errors
            if(! $customs || property_exists($customs, "error"))
            {
                if($request->ajax() || $request->wantsJson())
                    return response()->json([
                        'message' => 'Invalid credentials provided!',
                        'errors' => true,
                        'customs_error' => $customs->message ?? "Tokens could not be verified",
                    ], 422);

                // update request variables
                $this->resetRequestVariables($this->originalRequest);
                
                $errors = [
                    "auth" => ["Invalid login credentials"],
                    'email' => ['Incorrect email or password provided'],
                    'customs_error' => [$customs->message ?? "Tokens could not be verified"],
                ];
                return redirect()->back()->withErrors($errors);
            }
            
            // save to session
            session([
                'passport' => [
                    'access_token' => $customs->access_token,
                    'refresh_token' => $customs->refresh_token,
                ],
            ]);
            
            return $this->login($request);
        }
        
        if($request->ajax() || $request->wantsJson())
            return response()->json([
                'message' => 'Invalid credentials provided!',
                'errors' => true,
                'customs_error' => $resp ?? null,
            ], 422);

        // update request variables
        $this->resetRequestVariables($this->originalRequest);
        
        $errors = ["auth" => ["Invalid login credentials"], 'email' => ['Incorrect email or password provided'], 'customs_error' => ['Invalid oauth tokens'],];
        return redirect()->route('public.login')->withErrors($errors);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        // update request variables
        $this->resetRequestVariables($request);

        // record user login and spin up core activities
        event(new UserLoggedIn($this->originalRequest, $user));

        if ($request->ajax() or $request->wantsJson()) {
            return response()->json([
                    'message' => 'Login Successful',
                    'errors' => false,
                    'auth' => true,
                    'user_names' => $user->full_names,
                    'clinics' => doe()->clinics,
                    'access_token' => session('passport.access_token'),
                    'refresh_token' => session('passport.refresh_token'),
                ], 200);
        }
        
        return $this->getClinic();
    }

    /**
     * Present the view for selecting the clinic/facility after successful login attempt
     */
    public function getClinic()
    {
        $clinics = doe()->clinics;

        if (\Auth::user()->ex) {
            return redirect()->route('evaluation.exdoctor.patients');
        }
        return view('users::clinic', compact('clinics'));
    }

    /**
     * process the facility chosen and redirect to dashboard
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function setClinic(Request $request)
    {
        $request->session()->put('clinic', $request->clinic_id);
        $request->session()->put('facility', $request->clinic_id);
        
        if($request->ajax() || $request->wantsJson())
        {
            return response()->json([
                'message' => 'Clinic Selected',
                'errors' => false,
                'auth' => true,
                'intended_url' => route('system.dashboard'),
            ]);
        }

        return redirect()->route('system.dashboard');
    }

    
    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        // clear cache
        \Artisan::call('system:clear-local-cache');

        if($request->ajax() || $request->wantsJson())
        {
            return response()->json([
                'message' => 'Logged out Successfully',
                'alert' => 'success',
            ]);
        }

        return redirect('/');
    }
}
