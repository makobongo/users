<?php

Route::get('/dashboard', function() {
    return redirect()->route('users.index');
})->name('dashboard');


//Route::get('/', ['as' => 'index', 'uses' => 'UsersController@index']);
Route::get('/{id}/show', ['as' => 'show', 'uses' => 'UsersController@show']);

// clinics

/*
 * User Routes
 */
//Route::get('create', ['as' => 'index', 'uses' => 'UserController@create']);
//Route::get('{user}/edit', ['as' => 'index', 'uses' => 'UserController@edit']);

Route::get('delete/user/{user}', ['as' => 'purge', 'uses' => 'UsersController@purge_user']);

Route::get('/upload/',['as' => 'upload', 'uses' => 'UsersController@uploadUserDocument']);
Route::post('/upload/',['as' => 'upload', 'uses' => 'UsersController@processUserDocument']);

Route::get('manage/{user}/deactivate', ['as' => 'deactivate', 'uses' => 'UserController@deactivate']);
Route::get('manage/{user}/reactivate', ['as' => 'reactivate', 'uses' => 'UserController@reactivate']);
Route::get('manage/{user}/sendResetPassword', ['as' => 'sendResetPassword', 'uses' => 'UserController@sendResetPassword']); // hmm?

// injuries
Route::group(['prefix' => 'injuries', 'as' => 'injuries.'], function() {
    Route::get('{user?}', ['uses' => 'InjuryController@index', 'as' => 'index', "middleware" => "permission:users.injuries.index"]);
    Route::post('{user?}', ['uses' => 'InjuryController@store', 'as' => 'index', "middleware" => "permission:users.injuries.store"]);
});

// chits
Route::group(['prefix' => 'chits', 'as' => 'chits.'], function() {
    Route::get('{user?}', ['uses' => 'ChitController@index', 'as' => 'index', "middleware" => "permission:users.chits.index"]);
    Route::post('{user?}', ['uses' => 'ChitController@store', 'as' => 'store', "middleware" => "permission:users.chits.store"]);
    Route::get('delete/{id}', ['uses' => 'ChitController@print', 'as' => 'print', "middleware" => "permission:users.chits.print"]);
});

// roles and permissions
Route::group(['prefix' => 'roles', 'as' => 'role.'], function() {
    Route::get('/', ['uses' => 'RoleController@index', 'as' => 'index', "middleware" => "permission:users.roles.index"]);
    Route::post('/', ['uses' => 'RoleController@store', 'as' => 'store', "middleware" => "permission:users.roles.store"]);
    Route::get('{role}/edit', ['uses' => 'RoleController@edit', 'as' => 'edit', "middleware" => "permission:users.roles.update"]);
    Route::patch('{role}', ['uses' => 'RoleController@update', 'as' => 'update', "middleware" => "permission:users.roles.update"]);

});
Route::get("roles/{role}", ["uses" => "RoleController@show", "permission:users.roles.store", "as" => "role-permissions"]);

// employee categories
Route::resource('employee-categories', 'EmployeeCategoryController');

// user password mgmt
Route::get('password-management', ['uses' => 'PasswordController@index', 'as' => 'manage-password']);
Route::post('password-management', ['uses' => 'PasswordController@store', 'as' => 'manage-password-post']);
Route::get('hard-reset-password/{id}', ['uses' => 'PasswordController@hardReset', 'as' => 'hard-reset-password', 'middleware' => 'permission:users.hard-reset-user-password']);

// upload excel sheet containing list of employees
Route::group(['prefix' => 'excel/upload', 'as' => 'upload.'], function() {
    Route::get('employees', 'UploadDocumentController@employees')->name('employees');
    Route::post('employees', 'UploadDocumentController@employeesStore')->name('employees.store');
    Route::get('dependants', 'UploadDocumentController@dependants')->name('dependants');
    Route::post('dependants', 'UploadDocumentController@dependantsStore')->name('dependants.store');
});


// check roll numbers
Route::get('checkroll', 'CheckRollController@index')->name('checkroll.index');
Route::post('checkroll', 'CheckRollController@update')->name('checkroll.update');

// User routes
Route::get("/", ["uses" => "UserController@index", "middleware" => "permission:users.index", "as" => "index"]);
Route::post("/", ["uses" => "UserController@store", "middleware" => "permission:users.store", "as" => "store"]);
Route::get("/create", ["uses" => "UserController@create", "middleware" => "permission:users.store", "as" => "create"]);
Route::get("/{user}/edit", ["uses" => "UserController@edit", "middleware" => "permission:users.index", "as" => "edit"]);
Route::get("{user}/{view}", ["uses" => "UserController@show", "middleware" => "permission:users.index", "as" => "show"]);
Route::patch("{user}", ["uses" => "UserController@update", "middleware" => "permission:users.update", "as" => "update"]);
