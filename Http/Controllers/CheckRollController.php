<?php

namespace Ignite\Users\Http\Controllers;

use DB;
use Ignite\Core\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Ignite\Users\Entities\User;

class CheckRollController extends AdminBaseController
{
    /**
     * construct
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     * custom datatables querying
     * https://datatables.net/examples/data_sources/server_side.html
     * @return Response
     */
    public function index()
    {
        $users = User::orderBy('created_at','DESC');

        if(request()->search) {
            if(request()->names) {
                $search_value = request()->names;

                $users = $users
                    ->whereHas('profile', function($q) use ($search_value) {
                        $q->where('first_name', 'LIKE', '%' . $search_value . '%')
                        ->Orwhere('middle_name', 'LIKE', '%' . $search_value . '%')
                        ->Orwhere('last_name', 'LIKE', '%' . $search_value . '%');
                    });
            }

            if(request()->roll_no) {
                $search_value = request()->roll_no;

                $users = $users
                    ->whereHas('profile', function($q) use ($search_value) {
                        $q->where('roll_no', $search_value);
                    });
            }

            if(request()->id_number) {
                $search_value = request()->id_number;

                $users = $users
                    ->whereHas('profile', function($q) use ($search_value) {
                        $q->where('id_number', $search_value);
                    });
            }
        }

        $this->data['users'] = $users->paginate(users_paginate('checkroll'));

        return view('users::checkroll.index', $this->data);
    }

    /**
     * update users
     */
    public function update(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        // start a transaction
        try {
            DB::beginTransaction();

            // update user checkroll no
            $user->profile->update([
                'roll_no' => $request->roll_no,
            ]);
            // update user's patient record roll_no
            if($user->patient) {
                $user->patient->update([
                    'roll_no' => $request->roll_no,
                ]);
            }

            DB::commit();
        } catch(\Exception $e){
            DB::rollback();
            dd($e->getMessage());
            flash()->error($e->getMessage());
            return false;
        }

        if(request()->ajax()) {
            return response()->json([
                'data' => 'User Updated'
            ], 200);
        }

        return redirect()->back();
    }
}
