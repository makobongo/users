<?php

namespace Ignite\Users\Transformers;

use Ignite\Core\Library\Datatable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserResourceCollection extends ResourceCollection
{
    /*
    * Define the headers and consequently values for the data table
    */
    protected $headers = [
        ['text' => '#', 'value' => 'id'],
        'full name',
        "username", "email", "roles", "joined", "Actions"
    ];
    
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "data" => $this->collection,
            
            "headers" => (new Datatable)->headers($this->headers),
        ];
    }
}
