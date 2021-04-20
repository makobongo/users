<?php

namespace Ignite\Users\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Reports\Tranformers\UserTransformer;
use Ignite\Users\Entities\User;
use Ignite\Users\Http\Filters\UserFilter;
use Ignite\Users\Http\Requests\CredentialsRequest;
use Ignite\Users\Http\Requests\UserRequest;
use Ignite\Users\Repositories\RoleRepository;
use Ignite\Users\Repositories\Traits\UpdateUserTrait;
use Ignite\Users\Repositories\UsersRepository;
use Ignite\Users\Transformers\UserResource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class UserController extends AdminBaseController
{
    use UpdateUserTrait;

    protected $repo;

    public function __construct(UsersRepository $repo, RoleRepository $role)
    {
        parent::__construct();

        $this->repo = $repo;

        $this->role = $role;
    }

    /*
     * Show a listing of all the users
     */
    public function index()
    {
        if(request()->ajax()){
            if(request('search') || request('params')) {
                 return $this->repo->search();
            }

            if(request()->has('role')) {
                return $this->repo->filterByRole();
            }

            return $this->repo->get();
        }
        
        $users = $this->repo->all();

        return view('users::users.index', [
            'users' => $users
        ]);
    }

    /**
     * Creates a new user. Required variables are loaded via a view composer
     */
    public function create()
    {
        return view("users::users.create");
    }

    /*
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $form)
    {
        $resp = $this->repo->create();
        
        if(request()->ajax()) {
            if($resp) {
                return response()->json([
                    'message' => "User Added",
                    'alert' => 'success',
                    'user' => new UserResource($resp),
                ], 200);
            }
            
            return response()->json([
                'message' => 'An error occurred creating the user',
                'alert' => 'error',
            ], 422);
        }
        

        if($resp and !($resp instanceof RedirectResponse)) {
            flash("User created successfully", "success");
        }
        else if ($resp instanceof RedirectResponse) {
            return $resp;
        }
        else {
            flash("Something went wrong! Please try again.", "error");
        }

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     *
     * @return UserResource|Response
     */
    public function show($userId, $view)
    {
        $user = $this->repo->find($userId);
        
        if(request()->ajax()) {
            return new UserResource($user);
        }

        return view("users::users.profile.$view", [
            "user" => $user,
            "resources" => ["View", "Create", "Update", "Delete"],
            "groupedPermissions" => $this->role->groupedPermissions(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        return view('users::edit', [
            'userId' => $id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param CredentialsRequest $form
     * @param $userId
     * @return Response
     */
    public function update(CredentialsRequest $form , $userId)
    {
        $user = $this->repo->update($userId);

        if($user)
        {
            flash("User details updated successfully", "success");
        }
        else
        {
            flash("Something went wrong! Please try again.", "error");
        }
        if(request()->ajax())
        {
            return response()->json(["message"=>$user?"Success":"Error"],200);
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @return void
     */
    public function destroy()
    {
    }

    /**
     * deactivate a user. also deactivates dependants if any
     *
     * @param int $user_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deactivate($id)
    {
        $this->updateUserStatus($id, 0);

        flash('User has been deactivated', 'success');
        return redirect()->route('users.index');
    }

    /**
     * reactivate a user. also reactivates dependants if any
     * @param int $user_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reactivate($id)
    {
        $this->updateUserStatus($id, 1);

        flash('User has been reactivated', 'success');
        return redirect()->route('users.index');
    }
    
    /**
     * return honorifics
     *
     * @return mixed
     */
    public function honorifics()
    {
        return mconfig('users.users.titles');
    }
}
