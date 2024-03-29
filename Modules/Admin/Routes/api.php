<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/admin', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->prefix('auth')->group(function (){
    Route::get('/permissions/all-by-group-array', [
        'as' => 'api.permissions.all-by-group-array',
        'uses' => 'Auth\PermissionController@allByGroupArray',

    ]);
	Route::get('/permissions/all-by-group', [
		'as' => 'api.permissions.all-by-group',
		'uses' => 'Auth\PermissionController@allByGroup',

	]);
    Route::get('/permissions', [
        'as' => 'api.permissions.index',
        'uses' => 'Auth\PermissionController@index',

    ]);
    Route::delete('permissions/{permission}', [
        'as' => 'api.permissions.destroy',
        'uses' => 'Auth\PermissionController@destroy',

    ]);
    Route::post('permissions', [
        'as' => 'api.permissions.store',
        'uses' => 'Auth\PermissionController@store',

    ]);
    Route::get('permissions/{permission}', [
        'as' => 'api.permissions.find',
        'uses' => 'Auth\PermissionController@find',

    ]);
    Route::post('permissions/{permission}/edit', [
        'as' => 'api.permissions.update',
        'uses' => 'Auth\PermissionController@update',

    ]);
    //roles

    Route::get('/roles/all', [
        'as' => 'api.roles.all',
        'uses' => 'Auth\RoleController@all',

    ]);
    Route::get('/roles', [
        'as' => 'api.roles.index',
        'uses' => 'Auth\RoleController@index',

    ]);
    Route::get('/roles', [
        'as' => 'api.roles.index',
        'uses' => 'Auth\RoleController@index',

    ]);
    Route::delete('roles/{role}', [
        'as' => 'api.roles.destroy',
        'uses' => 'Auth\RoleController@destroy',

    ]);
    Route::post('roles', [
        'as' => 'api.roles.store',
        'uses' => 'Auth\RoleController@store',

    ]);
	Route::get('roles/find-new', [
		'as' => 'api.roles.find-new',
		'uses' => 'Auth\RoleController@findNew',

	]);
    Route::get('roles/{role}', [
        'as' => 'api.roles.find',
        'uses' => 'Auth\RoleController@find',

    ]);


    Route::post('roles/{role}/edit', [
        'as' => 'api.roles.update',
        'uses' => 'Auth\RoleController@update',

    ]);
    Route::post('roles/{role}/assign-permission', [
        'as' => 'api.roles.assignPermissions',
        'uses' => 'Auth\RoleController@assignPermissions',

    ]);
    Route::post('roles/{role}/remove-permission', [
        'as' => 'api.roles.removePermissions',
        'uses' => 'Auth\RoleController@removePermissions',

    ]);
    // users
    Route::get('users', [
        'as' => 'api.users.index',
        'uses' => 'Auth\UserController@index',

    ]);
    Route::delete('users/{user}', [
        'as' => 'api.users.destroy',
        'uses' => 'Auth\UserController@destroy',

    ]);

    Route::get('users/has-permissions', [
        'as' => 'api.users.hasPermissions',
        'uses' => 'Auth\UserController@hasPermissions',
    ]);

    Route::get('users/{user}', [
        'as' => 'api.users.find',
        'uses' => 'Auth\UserController@find',
    ]);
    Route::post('users/{user}/edit', [
        'as' => 'api.users.update',
        'uses' => 'Auth\UserController@update',

    ]);

    Route::get('users/profile/get', [
        'as' => 'api.users.profile',
        'uses' => 'Auth\UserController@profile',
    ]);

    Route::post('users', [
        'as' => 'api.users.store',
        'uses' => 'Auth\UserController@store',

    ]);
    Route::post('users/upload-avatar', [
        'as' => 'api.users.uploadAvatar',
        'uses' => 'Auth\UserController@uploadAvatar',

    ]);

    Route::post('users/{user}/change-password', [
        'as' => 'api.users.change-password',
        'uses' => 'Auth\UserController@changePassword',

    ]);
    Route::post('users/{user}/reset-password', [
        'as' => 'api.users.reset-password',
        'uses' => 'Auth\UserController@resetPassword',

    ]);

    Route::post('exports', [
        'as' => 'api.users.exports',
        'uses' => 'Auth\UserController@exports',

    ]);

    Route::post('imports', [
        'as' => 'api.users.imports',
        'uses' => 'Auth\UserController@imports',

    ]);

});




Route::middleware('auth:api')->prefix('/danh-muc')->group(function (){
    // alarm level

    Route::get('/', [
        'as' => 'api.category.index',
        'uses' => 'Category\CategoryController@index',

    ]);
    Route::delete('/{category}', [
        'as' => 'api.category.destroy',
        'uses' => 'Category\CategoryController@destroy',

    ]);

    Route::get('/{category}', [
        'as' => 'api.category.find',
        'uses' => 'Category\CategoryController@find',
    ]);
    Route::post('/{category}/edit', [
        'as' => 'api.category.update',
        'uses' => 'Category\CategoryController@update',

    ]);
    Route::post('/', [
        'as' => 'api.category.store',
        'uses' => 'Category\CategoryController@store',

    ]);
});

Route::middleware('auth:api')->prefix('/devices')->group(function (){

    Route::get('/', [
        'as' => 'api.device.index',
        'uses' => 'Device\DeviceController@index',
    ]);
    Route::post('/{device}/edit', [
            'as' => 'api.device.update',
            'uses' => 'Device\DeviceController@update',
        ]);
   Route::get('/{device}', [
              'as' => 'api.device.find',
              'uses' => 'Device\DeviceController@find',
          ]);
    Route::post('/', [
        'as' => 'api.device.store',
        'uses' => 'Device\DeviceController@store',
    ]);

    Route::delete('/{device}', [
        'as' => 'api.device.destroy',
        'uses' => 'Device\DeviceController@destroy',
    ]);

    Route::post('exports', [
        'as' => 'api.device.exports',
        'uses' => 'Device\DeviceController@exports',
    ]);

    Route::post('imports', [
        'as' => 'api.device.imports',
        'uses' => 'Device\DeviceController@imports',

    ]);
});

Route::middleware('auth:api')->prefix('/posts')->group(function (){

    Route::get('/', [
        'as' => 'api.post.index',
        'uses' => 'Post\PostController@index',
    ]);
    Route::post('/{post}/edit', [
            'as' => 'api.post.update',
            'uses' => 'Post\PostController@update',
        ]);
   Route::get('/{post}', [
              'as' => 'api.post.find',
              'uses' => 'Post\PostController@find',
          ]);
    Route::post('/', [
        'as' => 'api.post.store',
        'uses' => 'Post\PostController@store',
    ]);

    Route::delete('/{post}', [
        'as' => 'api.post.destroy',
        'uses' => 'Post\PostController@destroy',
    ]);
});
// append














