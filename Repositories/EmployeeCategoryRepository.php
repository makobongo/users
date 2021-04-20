<?php

namespace Ignite\Users\Repositories;

use Ignite\Users\Entities\EmployeeCategory;
use Ignite\Core\Repositories\EloquentBaseRepository;

class EmployeeCategoryRepository extends EloquentBaseRepository
{
	/**
     * @var \Illuminate\Database\Eloquent\Model An instance of the Eloquent Model
     */
    protected $model;
    
    /**
     * @param Model $model
     */
    public function __construct(EmployeeCategory $model)
    {
        $this->model = $model;
    }
}
