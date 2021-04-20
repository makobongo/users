<?php

namespace Ignite\Users\Http\Controllers;

use Ignite\Core\Http\Controllers\AdminBaseController;
use Ignite\Users\Repositories\EmployeeCategoryRepository;
use Illuminate\Http\Request;

class EmployeeCategoryController extends AdminBaseController {

    /**
     * @var EmployeeCategoryRepository
     */
    private $role;

    public function __construct(EmployeeCategoryRepository $repo) {
        parent::__construct();
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $employee_categories = $this->repo->all();
        return view('users::employee-categories.index', compact('employee_categories'));
    }

    /**
     * Display form for creating a new resource
     */
    public function create()
    {
    	return redirect()->route('users.employee-categories.index');
    }

    /**
     * store a new resource
     */
    public function store(Request $request)
    {
    	if (! $request->name)
    	{
    		flash()->error('Please provide the name');
    		return redirect()->back(); // move this later to request validation
    	}

    	$data = [
    		'name' => $request->name,
    		'description' => $request->description,
    	];

    	if ($this->repo->create($data))
    	{
    		flash()->success('Successfully Added');
    		return redirect()->route('users.employee-categories.index');
    	}

    	flash()->error('An error occurred. Please try again');
		return redirect()->back();
    }

    /**
     * edit a resource
     */
    public function edit($id)
    {
    	$employee_category = $this->repo->find($id);
    	$employee_categories = $this->repo->all();
        return view('users::employee-categories.index', compact('employee_categories', 'employee_category'));

    }

    /**
     * update a listing of the resource
     */
    public function update($id, Request $request)
    {
    	$data = [
    		'name' => $request->name,
    		'description' => $request->description,
    	];

    	if ($this->repo->update($this->repo->find($id), $data))
    	{
    		flash()->success('Successfully Updated');
    		return redirect()->route('users.employee-categories.index');
    	}
    	flash()->error('An error occurred. Please try again');
		return redirect()->back();
    }

    /**
     * destroy a listing of the resource
     */
    public function destroy($id)
    {
    	if ($this->repo->destroy($this->repo->find($id)))
    	{
    		flash()->success('Successfully Deleted');
    		return redirect()->route('users.employee-categories.index');
    	}
    	flash()->error('An error occurred. Please try again');
		return redirect()->back();
    }
}
