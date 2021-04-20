<?php

namespace Ignite\Users\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Users\Entities\Injuries;
use Ignite\Users\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class InjuryController extends AdminBaseController
{
    protected $model;

    /**
    * Constructor
    *
    */
    public function __construct()
    {
        parent::__construct();
        $this->model = new Injuries;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $injuries = $this->model->get();
        $users = User::all();

        return view('users::injuries', compact('injuries', 'users'));
    }

    /**
     * save an injury
     * TODO: use injuryRequest later
     */
    public function store(Request $request)
    {
        $this->model->employee = $request->employee;
        $this->model->check_roll_number = $request->check_roll_number;
        $this->model->injury = $request->injury;
        $this->model->statement = $request->statement;
        $this->model->remarks = $request->remarks;
        $this->model->user = \Auth::id();

        if($this->model->save()) {
            flash()->success('Chit Saved');
        } else {
            flash()->error('An error occurred!');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    //
    }
}
