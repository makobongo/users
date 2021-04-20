<?php

namespace Ignite\Users\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Users\Entities\User;
use Ignite\Users\Http\Filters\UserFilter;
use Illuminate\Http\Response;

class UserRoleGroupController extends AdminBaseController
{



    /**
     * Show the specified resource.
     * @param UserFilter $filter
     * @return Response
     */
    public function show(UserFilter $filter)
    {
        $group = request('group');
        $user = $filter->sieve(User::class)->whereHas('roles',function($q) use($group){
            $q->whereIn('name',$group);
        })->get();

        return response()->json($user);
    }

}
