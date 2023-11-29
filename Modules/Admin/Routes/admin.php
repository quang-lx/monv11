<?php

/*
|--------------------------------------------------------------------------
| Web Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Support\Facades\Route;

Route::get('need-change-password', [
    'as' => 'admin.need_change_password',
    'uses' => 'HomeController@showNeedChangePasswrod',

]);

Route::get('/', [
    'as' => 'admin.dashboard.index',
    'uses' => 'HomeController@index',

])->middleware('permission:admin.dashboard.index');


Route::group(['prefix' =>'/auth'], function (){
    Route::group(['prefix' => 'quan-tri'], function () {
        Route::get('/', [
            'as' => 'admin.admins.index',
            'uses' => 'Auth\AdminUserController@index',

        ])->middleware('permission:admin.admins.index');
        Route::get('/create', [
            'as' => 'admin.admins.create',
            'uses' => 'Auth\AdminUserController@create',

        ])->middleware('permission:admin.admins.create');
        Route::get('/{user}/edit', [
            'as' => 'admin.admins.edit',
            'uses' => 'Auth\AdminUserController@edit',

        ])->middleware('permission:admin.admins.edit');
    });
    // user
    Route::get('/users', [
        'as' => 'admin.users.index',
        'uses' => 'Auth\UserController@index',

    ])->middleware('permission:admin.users.index');
    Route::get('users/create', [
        'as' => 'admin.users.create',
        'uses' => 'Auth\UserController@create',
    ])->middleware('permission:admin.users.create');

    Route::get('users/{user}/edit', [
        'as' => 'admin.users.edit',
        'uses' => 'Auth\UserController@edit',
    ])->middleware('permission:admin.users.edit');

    // permission
    Route::get('/permissions', [
        'as' => 'admin.permissions.index',
        'uses' => 'Auth\PermissionController@index',

    ])->middleware('permission:admin.permissions.index');
    Route::get('permissions/create', [
        'as' => 'admin.permissions.create',
        'uses' => 'Auth\PermissionController@create',
    ])->middleware('permission:admin.permissions.create');

    Route::get('permissions/{permission}/edit', [
        'as' => 'admin.permissions.edit',
        'uses' => 'Auth\PermissionController@edit',
    ])->middleware('permission:admin.permissions.edit');

    // role
    Route::get('/roles', [
        'as' => 'admin.roles.index',
        'uses' => 'Auth\RoleController@index',

    ])->middleware('permission:admin.roles.index');
    Route::get('roles/create', [
        'as' => 'admin.roles.create',
        'uses' => 'Auth\RoleController@create',
    ])->middleware('permission:admin.roles.create');

    Route::get('roles/{role}/edit', [
        'as' => 'admin.roles.edit',
        'uses' => 'Auth\RoleController@edit',
    ])->middleware('permission:admin.roles.edit');
});
Route::group(['prefix' => '/media'], function ( ) {
    Route::get('media', [
        'as' => 'admin.media.index',
        'uses' => 'Media\MediaController@index',
    ])->middleware('permission:admin.media.index');
    Route::get('media/create', [
        'as' => 'admin.media.create',
        'uses' => 'Media\MediaController@create',
    ])->middleware('permission:admin.media.create');
    Route::post('media', [
        'as' => 'admin.media.store',
        'uses' => 'Media\MediaController@store',
    ])->middleware('permission:admin.media.store');
    Route::get('media/{media}/edit', [
        'as' => 'admin.media.edit',
        'uses' => 'Media\MediaController@edit',
    ])->middleware('permission:admin.media.edit');
    Route::put('media/{media}', [
        'as' => 'admin.media.update',
        'uses' => 'Media\MediaController@update',
    ])->middleware('permission:admin.media.update');
    Route::delete('media/{media}', [
        'as' => 'admin.media.destroy',
        'uses' => 'Media\MediaController@destroy',
    ])->middleware('permission:admin.media.destroy');


});



Route::group(['prefix' => '/danh-muc'], function ( ) {

	Route::get('/', [
		'as' => 'admin.category.index',
		'uses' => 'Category\CategoryController@index',

	])->middleware('permission:admin.category.index');
	Route::get('/create', [
		'as' => 'admin.category.create',
		'uses' => 'Category\CategoryController@create',

	])->middleware('permission:admin.category.create');
	Route::get('/{category}/edit', [
		'as' => 'admin.category.edit',
		'uses' => 'Category\CategoryController@edit',

	])->middleware('permission:admin.category.edit');

});


Route::group(['prefix' => '/department'], function ( ) {

    Route::get('/', [
        'as' => 'admin.department.index',
        'uses' => 'Department\DepartmentController@index',
        'middleware' => 'permission:admin.department.index'
    ]);
    Route::get('create', [
        'as' => 'admin.department.create',
        'uses' => 'Department\DepartmentController@create',
        'middleware' => 'permission:admin.department.create'
    ]);

    Route::get('{department}/edit', [
        'as' => 'admin.department.edit',
        'uses' => 'Department\DepartmentController@edit',
        'middleware' => 'permission:admin.department.edit'
    ]);


});
Route::group(['prefix' =>'/profile'], function (){
    Route::get('edit', [
        'as' => 'admin.profile.edit',
        'uses' => 'Auth\UserController@profile',
        'middleware' => 'permission:admin.profile.edit'
    ]);
});

Route::group(['prefix' => '/department'], function ( ) {

    Route::get('/', [
        'as' => 'admin.department.index',
        'uses' => 'Department\DepartmentController@index',
        'middleware' => 'permission:admin.department.index'
    ]);
    Route::get('create', [
        'as' => 'admin.department.create',
        'uses' => 'Department\DepartmentController@create',
        'middleware' => 'permission:admin.department.create'
    ]);

    Route::get('{department}/edit', [
        'as' => 'admin.department.edit',
        'uses' => 'Department\DepartmentController@edit',
        'middleware' => 'permission:admin.department.edit'
    ]);

});
Route::group(['prefix' => '/configdisplay'], function ( ) {

    Route::get('/', [
        'as' => 'admin.configdisplay.index',
        'uses' => 'ConfigDisplay\ConfigDisplayController@index',
        'middleware' => 'permission:admin.configdisplay.index'
    ]);
    Route::get('create', [
        'as' => 'admin.configdisplay.create',
        'uses' => 'ConfigDisplay\ConfigDisplayController@create',
        'middleware' => 'permission:admin.configdisplay.create'
    ]);

    Route::get('{configdisplay}/edit', [
        'as' => 'admin.configdisplay.edit',
        'uses' => 'ConfigDisplay\ConfigDisplayController@edit',
        'middleware' => 'permission:admin.configdisplay.edit'
    ]);


});
Route::group(['prefix' => '/device'], function ( ) {

    Route::get('/', [
        'as' => 'admin.device.index',
        'uses' => 'Device\DeviceController@index',
        'middleware' => 'permission:admin.device.index'
    ]);
    Route::get('create', [
        'as' => 'admin.device.create',
        'uses' => 'Device\DeviceController@create',
        'middleware' => 'permission:admin.device.create'
    ]);

    Route::get('{device}/edit', [
        'as' => 'admin.device.edit',
        'uses' => 'Device\DeviceController@edit',
        'middleware' => 'permission:admin.device.edit'
    ]);


});
Route::group(['prefix' => '/service'], function ( ) {

    Route::get('/', [
        'as' => 'admin.service.index',
        'uses' => 'TestingService\TestingServiceController@index',
        'middleware' => 'permission:admin.service.index'
    ]);
    Route::get('create', [
        'as' => 'admin.service.create',
        'uses' => 'TestingService\TestingServiceController@create',
        'middleware' => 'permission:admin.service.create'
    ]);

    Route::get('{testingservice}/edit', [
        'as' => 'admin.service.edit',
        'uses' => 'TestingService\TestingServiceController@edit',
        'middleware' => 'permission:admin.service.edit'
    ]);


});
Route::group(['prefix' => '/service-index'], function ( ) {

    Route::get('/', [
        'as' => 'admin.serviceindex.index',
        'uses' => 'ServiceIndex\ServiceIndexController@index',
        'middleware' => 'permission:admin.serviceindex.index'
    ]);
    Route::get('create', [
        'as' => 'admin.serviceindex.create',
        'uses' => 'ServiceIndex\ServiceIndexController@create',
        'middleware' => 'permission:admin.serviceindex.create'
    ]);

    Route::get('{serviceindex}/edit', [
        'as' => 'admin.serviceindex.edit',
        'uses' => 'ServiceIndex\ServiceIndexController@edit',
        'middleware' => 'permission:admin.serviceindex.edit'
    ]);


});
Route::group(['prefix' => '/disease'], function ( ) {

    Route::get('/', [
        'as' => 'admin.disease.index',
        'uses' => 'Disease\DiseaseController@index',
        'middleware' => 'permission:admin.disease.index'
    ]);
    Route::get('create', [
        'as' => 'admin.disease.create',
        'uses' => 'Disease\DiseaseController@create',
        'middleware' => 'permission:admin.disease.create'
    ]);

    Route::get('{disease}/edit', [
        'as' => 'admin.disease.edit',
        'uses' => 'Disease\DiseaseController@edit',
        'middleware' => 'permission:admin.disease.edit'
    ]);


});
Route::group(['prefix' => '/servicetype'], function ( ) {

    Route::get('/', [
        'as' => 'admin.servicetype.index',
        'uses' => 'ServiceType\ServiceTypeController@index',
        'middleware' => 'permission:admin.servicetype.index'
    ]);
    Route::get('create', [
        'as' => 'admin.servicetype.create',
        'uses' => 'ServiceType\ServiceTypeController@create',
        'middleware' => 'permission:admin.servicetype.create'
    ]);

    Route::get('{servicetype}/edit', [
        'as' => 'admin.servicetype.edit',
        'uses' => 'ServiceType\ServiceTypeController@edit',
        'middleware' => 'permission:admin.servicetype.edit'
    ]);
});
Route::group(['prefix' => '/patient'], function ( ) {

    Route::get('/', [
        'as' => 'admin.patient.index',
        'uses' => 'Patient\PatientController@index',
        'middleware' => 'permission:admin.patient.index'
    ]);
    Route::get('create', [
        'as' => 'admin.patient.create',
        'uses' => 'Patient\PatientController@create',
        'middleware' => 'permission:admin.patient.create'
    ]);

    Route::get('{patient}/edit', [
        'as' => 'admin.patient.edit',
        'uses' => 'Patient\PatientController@edit',
        'middleware' => 'permission:admin.patient.edit'
    ]);


});
// append









