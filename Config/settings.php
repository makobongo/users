<?php


return[
    'max_dependants_per_user' => [
        'description' => 'Maximum Number of Dependants a user can have',
        'view' => 'number',
        'hint' => 'Mostly set to four'
    ],

    'max_age_of_dependant' => [
        'description' => 'Maximum age of a dependant eligible for Willson Cover',
        'view' => 'number',
        'hint' => '18 yrs. You can set to 1000 years if there is no restriction on a dependant\'s age'
    ],

    'enable_injuries' => [
        'view' => 'checkbox',
        'description' => 'Enable Injuries'
    ],

    'enable_chits' => [
        'view' => 'checkbox',
        'description' => 'Enable Chits'
    ],

    'enable_employee_categories' => [
        'view' => 'checkbox',
        'description' => 'Enable Employee Categories setting'
    ],

    'enable_dependants' => [
        'view' => 'checkbox',
        'description' => 'Enable Employee Dependants setting'
    ],

    'enable_check_roll_number' => [
        'view' => 'checkbox',
        'description' => 'Enable Employee Check-Roll Number specification'
    ],
    
    /*
      |--------------------------------------------------------------------------
      | Sidebar Naming
      |--------------------------------------------------------------------------
      |
      | This option controls the naming for sidebar entries
      |
     */
    'sidebar_name_users_and_employees' => [
        'view' => 'text',
        'description' => 'Sidebar Name: Users & Employees',
        'default' => 'Users & Employees'
    ],
    
    'sidebar_name_new_user' => [
        'view' => 'text',
        'description' => 'Sidebar Name: New User',
        'default' => 'New User'
    ],
    
    'sidebar_name_all_users' => [
        'view' => 'text',
        'description' => 'Sidebar Name: All Users',
        'default' => 'All Users'
    ],
    
    'sidebar_name_roles' => [
        'view' => 'text',
        'description' => 'Sidebar Name: Roles',
        'default' => 'Roles'
    ],
    
    'sidebar_name_employee_categories' => [
        'view' => 'text',
        'description' => 'Sidebar Name: Employee Categories',
        'default' => 'Employee Categories'
    ],
    
    'sidebar_name_checkroll_numbers' => [
        'view' => 'text',
        'description' => 'Sidebar Name: CheckRoll Numbers',
        'default' => 'CheckRoll Numbers'
    ],
];
