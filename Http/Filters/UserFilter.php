<?php

namespace Ignite\Users\Http\Filters;

use Agog\Osmose\Library\FormFilter;
use Agog\Osmose\Library\FilterInterface;

class UserFilter extends FormFilter implements FilterInterface
{
    /**
     * Defines form elements and sieve values
     * @return array
     */
    protected $dates = false;

    public function residue()
    {
        return [
            "role" => "column:name,roles",
//            "facility" => "column:clinic_id,clinics"
        ];
    }
}
