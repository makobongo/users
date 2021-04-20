<?php

namespace Ignite\Users\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Users\Entities\Chit;
use Ignite\Users\Entities\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class ChitController extends AdminBaseController
{

    /**
     * @var Chit
     */
    protected $model;

    /**
    * Constructor
    *
    */
    public function __construct()
    {
        parent::__construct();
        $this->model = new Chit; // Can be type-hinted, but naah
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $chits = $this->model->all();
        $users = User::all();

        return view('users::chits.index', compact('chits', 'users'));
    }

    /**
     * store a new chit
     * TODO: improve this thing later men + ChitRequest
     */
    public function store(Request $request)
    {
        $chit = $this->model;

        $chit->employee_id = $request->employee;
        $chit->category = $request->category;
        $chit->description = $request->description;
        $chit->duration = $request->duration;
        $chit->time_measure = $request->time_measure;
        $chit->user_id = \Auth::id();

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $dir = base_path('public/employee/chits/');
            $file_name = md5(time()) . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $file_name);
            $chit->filepath = 'public/employee/chits/' . $file_name;
            $chit->mime = $file->getClientMimeType();
            $chit->filename = $file_name;
            // } else {
            //     flash("you need to upload a file to proceed", "warning");
            //     return back();
        }
        $chit->save();

        // redirect to chits to avoid posting twice
        return redirect()->route('users.chits');
    }

    /**
     * delete a chit.
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        $chit = $this->model->findOrFail($request->id);

        $file = public_path('employee/chits/' . $chit->filename);
        if (file_exists($file)) {
            unlink($file);
        }
        $chit->delete();

        flash('Data deleted successfully', 'success');
        return back();
    }

    /**
     * print a chit
     * @var int $id
     */
    public function print($id)
    {
        $data['chit'] = $this->model->findOrFail($id);
        $pdf = \PDF::loadView("users::chits.print", $data);

        return @$pdf->stream("Employee Chit.pdf");
    }

}
