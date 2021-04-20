<?php

/** @var  \Illuminate\Routing\Router $router */

# Login
$router->get('login', ['middleware' => 'guest', 'as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
$router->post('login', ['as' => 'login.post', 'uses' => 'Auth\LoginController@authenticate']);

$router->get('clinic-select', ['as' => 'clinic.select', 'uses' => 'Auth\LoginController@getClinic']);
$router->get('clinic-select', ['as' => 'clinic.post', 'uses' => 'Auth\LoginController@setClinic']);

$router->get('register', ['middleware' => 'guest', 'as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
$router->post('register', ['as' => 'register.post', 'uses' => 'Auth\RegisterController@register']);
$router->get('verifyemail/{token}',['as'=>'verify.email', 'uses'=>'Auth\RegisterController@verify']);

// Password Reset Routes
$router->post('password/email', [ 'as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail' ]);
$router->get('password/reset', [ 'as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm' ]);
$router->post('password/reset', [ 'as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@reset' ]);
$router->get('password/reset/{token}', [ 'as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm' ]);

# Logout
$router->get('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
$router->post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);
