<?php

namespace Ignite\Users\Repositories;

use Ignite\Users\Entities\Dependants;
use Ignite\Core\Repositories\EloquentBaseRepository;

class DependantRepository extends EloquentBaseRepository
{
	/**
     * @var \Illuminate\Database\Eloquent\Model An instance of the Eloquent Model
     */
    protected $model;
    
    /**
     * @param Model $model
     */
    public function __construct(Dependants $model)
    {
        $this->model = $model;
    }
}
