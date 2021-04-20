<?php

namespace Ignite\Users\Library\Traits;


trait PermissionsGeneratorTrait
{
    /*
     * Generates permissions given an array that matches them to modules
     */
    public function generate($general, $resourceful)
    {
        return array_merge(
            $this->resourcefulPermissions($resourceful),
            $this->generalPermissions($general)
        );
    }

    /*
     * Generates resourceful permissions
     */
    public function resourcefulPermissions($data)
    {
        $crud = [
            'index' => 'View all %s',

            'store' => 'Create a %s',

            'update' => 'Update a %s',

            'destroy' => 'Delete a %s',
        ];

        $collection = [];

        foreach(array_collapse($data) as $module => $permissions)
        {
            foreach($permissions as $permission)
            {
                foreach ($crud as $resource => $description)
                {
                    $name = $module == $permission ? "${permission}.${resource}" : "${module}.${permission}.${resource}";

                    if ($resource == "index")
                    {
                        $display_name = "View ${permission}";

                        $print = $permission;
                    }
                    else
                    {
                        $print = str_singular($permission);

                        $display_name = ucwords($resource) . " " . $print;
                    }

                    $description = sprintf($description, $print);

                    $resource = $permission;

                    array_push($collection, compact('name', 'display_name', 'description', 'module', 'resource'));
                }
            }
        }

        return $collection;
    }

    /*
     * Generates general permissions
     */
    public function generalPermissions($data)
    {
        $collection = [];

        foreach(array_collapse($data) as $key => $value)
        {
            
            foreach($value as $permission)
            {
                $name = $key . "." . $permission;
                $display_name = str_replace("-", " ", $permission);
                $description = "Access ${display_name}";
                $special = true;
                $module = $key;

                array_push($collection, compact('name', 'display_name', 'description', 'special', 'module'));
            }
        }

        return $collection;
    }
}
