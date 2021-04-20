<?php

use Ignite\Users\Transformers\UserResource;
use Illuminate\Http\Request;

// return currently logged in user
Route::get('logged-in-user', function(Request $request) {
    return new UserResource($request->user());
})->name('logged-in-user')->middleware('auth:api');


Route::post('role/{role}', ['as' => 'role.update', 'uses' => 'RoleController@update']);
Route::post('user/{user}', ['as' => 'update', 'uses' => 'UserController@update']);

/*
 * Users authentication
 */
Route::post("authenticate", ["uses" => "Auth\LoginController@authenticate"])->name('authenticate');

//users  *removed for testing  "middleware" => "permission:users.index"
Route::get("/", ["uses" => "UserController@index", "as" => "index"]);


Route::group(["middleware" => "auth:api"], function($router){
    /*
     * Users routes
     */
    Route::get("users", ["uses" => "UserController@index", "middleware" => ["permission:users.index"]]);

    /**
     * Permissions and specific user permissions and authorizations
     */
    Route::get('/userPermissions', 'PermissionController@allowed');

    /**
     * get a user's roles
     */
    $router->get('/userRoles/{user_id?}', 'RoleController@userRoles');
    
    Route::post("/", ["uses" => "UserController@store", "middleware" => "permission:users.store", "as" => "store"]);
    
});

Route::post("/user-group", ["uses" => "UserRoleGroupController@show","as" => "group.show"]);

Route::get("/honorifics", ["uses" => "UserController@honorifics","as" => "honorifics.index"]);

Route::get("/roles", ["uses" => "RoleController@index","as" => "roles.index"]);

Route::post("/deployment", ["uses" => "DeploymentController@store", "as" => "deploy"]);

