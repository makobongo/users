<?php

return [
	'name' => 'Users',
	'pagination' => [
		'default' => 300,
		'users' => 100,
		'checkroll' => 300,
	],

    'passport' => [
        'grant_type' => 'password',
        'client_id' => env('PASSPORT_CLIENT'),
        'client_secret' => env('PASSPORT_TOKEN'),
        'scope' => ''
    ],
    
    'max_users' => env('ACEMED_MAX_USERS', null),
    
];
