<?php

namespace Ignite\Users\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Users\Entities\User;
use Ignite\Users\Foundation\PermissionManager;
use Ignite\Users\Http\Requests\RolesRequest;
use Ignite\Users\Repositories\RoleRepository;
use Ignite\Users\Transformers\RoleResource;
use Illuminate\Http\Request;

class RoleController extends AdminBaseController
{
    private $repo;

    public function __construct(RoleRepository $repo)
    {
        parent::__construct();

        $this->repo = $repo;
    }

    /*
     * Show all roles in the system
     */
    public function index()
    {
        $roles = $this->repo->all();
        
        if(request()->ajax()) {
            return RoleResource::collection($roles);
        }

        return view("users::roles.index", compact("roles"));
    }

    /*
     * Store a new role
     */
    public function store(RolesRequest $request)
    {
        if($this->repo->create())
        {
            flash("Role saved successfully.", "success");
        }
        else
        {
            flash("Something went wrong! Please try again.", "error");
        }

        return redirect()->back();
    }

    /*
     * Show all roles in the system
     */
    public function edit($id)
    {
        $roles = $this->repo->all();

        $role = $this->repo->find($id);

        return view("users::roles.index", compact("roles", "role"));
    }

    /*
     * Show a particular role and present permission updating view
     */
    public function show($id)
    {
        return view("users::roles.show", [
            "role" => $this->repo->find($id),
            "resources" => ["View", "Create", "Update", "Delete"],
            "groupedPermissions" => $this->repo->groupedPermissions(),
        ]);
    }

    /*
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {
        $role = $this->repo->find($id);

        if(request()->has("permission"))
        {
            $permission = request("permission");

            $role->hasPermission($permission) ? $role->detachPermission($permission) : $role->attachPermission($permission);
        }

        if(! request()->has('name'))
        {
            // then only permission is being updated
            return response()->json([
                'message' => 'Role permissions updated',
                'alert' => 'success'
            ], 200);
        }

        // update role
        if($this->repo->update($role))
        {
            if($request->ajax()) {
                return response()->json([
                    'message' => 'Role updated',
                    'alert' => 'success'
                ], 200);
            } else {
                flash()->success('Role updated');
            }
        } else {
            if($request->ajax()) {
                return response()->json([
                    'message' => 'Role was not updated. There exists a role with such a name',
                    'alert' => 'error'
                ], 422);
            } else {
                flash()->error('Role was not updated. There exists a role with such a name');
            }
        }

        return redirect()->route('users.role.index');
    }

    /**
     * get a user's roles. Good for approving/authorizing stuff based on user's role
     *
     * @param $user_id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userRoles($user_id = null)
    {
        $user = $user_id ? User::findOrFail($user_id) : doe();

        return response()->json([
            'roles' => $user->roles,
            ], 200);
    }
}
