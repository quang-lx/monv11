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


Route::middleware('auth:api')->prefix('/departments')->group(function (){
    Route::get('/tree', [
        'as' => 'api.department.tree',
        'uses' => 'Department\DepartmentController@tree',
    ]);
    Route::get('/hierarchy', [
        'as' => 'api.department.hierarchy',
        'uses' => 'Department\DepartmentController@getAllHierarchy',
    ]);
    Route::get('/', [
        'as' => 'api.department.index',
        'uses' => 'Department\DepartmentController@index',
    ]);
    Route::post('/{department}/edit', [
            'as' => 'api.department.update',
            'uses' => 'Department\DepartmentController@update',
        ]);
   Route::get('/{department}', [
              'as' => 'api.department.find',
              'uses' => 'Department\DepartmentController@find',
          ]);
    Route::post('/', [
        'as' => 'api.department.store',
        'uses' => 'Department\DepartmentController@store',
    ]);

    Route::delete('/{department}', [
        'as' => 'api.department.destroy',
        'uses' => 'Department\DepartmentController@destroy',
    ]);

    Route::get('/not-assign/count', [
        'as' => 'api.department.countNotAssign',
        'uses' => 'Department\DepartmentController@countNotAssign',
    ]);
});
Route::middleware('auth:api')->prefix('/configdisplays')->group(function (){

    Route::get('/', [
        'as' => 'api.configdisplay.index',
        'uses' => 'ConfigDisplay\ConfigDisplayController@index',
    ]);
    Route::post('/{configdisplay}/edit', [
            'as' => 'api.configdisplay.update',
            'uses' => 'ConfigDisplay\ConfigDisplayController@update',
        ]);
   Route::get('/{configdisplay}', [
              'as' => 'api.configdisplay.find',
              'uses' => 'ConfigDisplay\ConfigDisplayController@find',
          ]);
    Route::post('/', [
        'as' => 'api.configdisplay.store',
        'uses' => 'ConfigDisplay\ConfigDisplayController@store',
    ]);

    Route::delete('/{configdisplay}', [
        'as' => 'api.configdisplay.destroy',
        'uses' => 'ConfigDisplay\ConfigDisplayController@destroy',
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
Route::middleware('auth:api')->prefix('/service')->group(function (){

    Route::get('/', [
        'as' => 'api.service.index',
        'uses' => 'TestingService\TestingServiceController@index',
    ]);
    Route::post('/{testingservice}/edit', [
            'as' => 'api.service.update',
            'uses' => 'TestingService\TestingServiceController@update',
        ]);
   Route::get('/{testingservice}', [
              'as' => 'api.service.find',
              'uses' => 'TestingService\TestingServiceController@find',
          ]);
    Route::post('/', [
        'as' => 'api.service.store',
        'uses' => 'TestingService\TestingServiceController@store',
    ]);

    Route::delete('/{testingservice}', [
        'as' => 'api.service.destroy',
        'uses' => 'TestingService\TestingServiceController@destroy',
    ]);
    Route::post('imports', [
        'as' => 'api.service.imports',
        'uses' => 'TestingService\TestingServiceController@imports',

    ]);

    Route::post('exports', [
        'as' => 'api.service.exports',
        'uses' => 'TestingService\TestingServiceController@exports',

    ]);
});
Route::middleware('auth:api')->prefix('/serviceindices')->group(function (){

    Route::get('/', [
        'as' => 'api.serviceindex.index',
        'uses' => 'ServiceIndex\ServiceIndexController@index',
    ]);
    Route::post('/{serviceindex}/edit', [
            'as' => 'api.serviceindex.update',
            'uses' => 'ServiceIndex\ServiceIndexController@update',
        ]);
   Route::get('/{serviceindex}', [
              'as' => 'api.serviceindex.find',
              'uses' => 'ServiceIndex\ServiceIndexController@find',
          ]);
    Route::post('/', [
        'as' => 'api.serviceindex.store',
        'uses' => 'ServiceIndex\ServiceIndexController@store',
    ]);

    Route::delete('/{serviceindex}', [
        'as' => 'api.serviceindex.destroy',
        'uses' => 'ServiceIndex\ServiceIndexController@destroy',
    ]);
});
Route::middleware('auth:api')->prefix('/diseases')->group(function (){

    Route::get('/', [
        'as' => 'api.disease.index',
        'uses' => 'Disease\DiseaseController@index',
    ]);
    Route::post('/{disease}/edit', [
            'as' => 'api.disease.update',
            'uses' => 'Disease\DiseaseController@update',
        ]);
   Route::get('/{disease}', [
              'as' => 'api.disease.find',
              'uses' => 'Disease\DiseaseController@find',
          ]);
    Route::post('/', [
        'as' => 'api.disease.store',
        'uses' => 'Disease\DiseaseController@store',
    ]);

    Route::delete('/{disease}', [
        'as' => 'api.disease.destroy',
        'uses' => 'Disease\DiseaseController@destroy',
    ]);

    Route::post('exports', [
        'as' => 'api.disease.exports',
        'uses' => 'Disease\DiseaseController@exports',
    ]);

    Route::post('imports', [
        'as' => 'api.disease.imports',
        'uses' => 'Disease\DiseaseController@imports',

    ]);
});
Route::middleware('auth:api')->prefix('/servicetypes')->group(function (){

    Route::get('/', [
        'as' => 'api.servicetype.index',
        'uses' => 'ServiceType\ServiceTypeController@index',
    ]);
    Route::post('/{servicetype}/edit', [
            'as' => 'api.servicetype.update',
            'uses' => 'ServiceType\ServiceTypeController@update',
        ]);
   Route::get('/{servicetype}', [
              'as' => 'api.servicetype.find',
              'uses' => 'ServiceType\ServiceTypeController@find',
          ]);
    Route::post('/', [
        'as' => 'api.servicetype.store',
        'uses' => 'ServiceType\ServiceTypeController@store',
    ]);

    Route::delete('/{servicetype}', [
        'as' => 'api.servicetype.destroy',
        'uses' => 'ServiceType\ServiceTypeController@destroy',
    ]);
});
Route::middleware('auth:api')->prefix('/patients')->group(function (){

    Route::get('/', [
        'as' => 'api.patient.index',
        'uses' => 'Patient\PatientController@index',
    ]);
    Route::post('/{patient}/edit', [
            'as' => 'api.patient.update',
            'uses' => 'Patient\PatientController@update',
        ]);
    Route::post('/{patient}/re-examination', [
            'as' => 'api.patient.reExamination',
            'uses' => 'Patient\PatientController@reExamination',
        ]);
    Route::post('/{patient}/add-service', [
            'as' => 'api.patient.addService',
            'uses' => 'Patient\PatientController@addService',
        ]);
    Route::delete('/{patient}/delete-service', [
        'as' => 'api.patient.deleteService',
        'uses' => 'Patient\PatientController@deleteService',
    ]);
    Route::post('/{patient}/cancel-service', [
        'as' => 'api.patient.cancelService',
        'uses' => 'Patient\PatientController@cancelService',
    ]);
   Route::get('/{patient}', [
              'as' => 'api.patient.find',
              'uses' => 'Patient\PatientController@find',
          ]);
    Route::post('/', [
        'as' => 'api.patient.store',
        'uses' => 'Patient\PatientController@store',
    ]);

    Route::get('/{patient}/examination-service/get', [
        'as' => 'api.patient.examinationService',
        'uses' => 'Patient\PatientController@getExaminationService',
    ]);

    Route::delete('/{patient}', [
        'as' => 'api.patient.destroy',
        'uses' => 'Patient\PatientController@destroy',
    ]);

    Route::post('exports', [
        'as' => 'api.patient.exports',
        'uses' => 'Patient\PatientController@exports',
    ]);
    Route::get('get-by-phone/all', [
        'as' => 'api.patient.getPatientViaPhone',
        'uses' => 'Patient\PatientController@getPatientViaPhone',
    ]);

    Route::post('imports', [
        'as' => 'api.patient.imports',
        'uses' => 'Patient\PatientController@imports',

    ]);

    Route::post('change_status', [
        'as' => 'api.patient.change_status',
        'uses' => 'Patient\PatientController@changeStatus',

    ]);

});
Route::middleware('auth:api')->prefix('/patient-examinations')->group(function (){

    Route::get('/', [
        'as' => 'api.patientexamination.index',
        'uses' => 'PatientExamination\PatientExaminationController@index',
    ]);
    Route::get('/list-via-patient', [
        'as' => 'api.patientexamination.listViaPatient',
        'uses' => 'PatientExamination\PatientExaminationController@listViaPatient',
    ]);
    Route::post('/{patientexamination}/edit', [
            'as' => 'api.patientexamination.update',
            'uses' => 'PatientExamination\PatientExaminationController@update',
        ]);
    Route::post('/{patientexamination}/start', [
        'as' => 'api.patientexamination.startExamination',
        'uses' => 'PatientExamination\PatientExaminationController@startExamination',
    ]);
    Route::post('/{patientexamination}/finish', [
        'as' => 'api.patientexamination.finishExamination',
        'uses' => 'PatientExamination\PatientExaminationController@finishExamination',
    ]);
   Route::get('/{patientexamination}', [
              'as' => 'api.patientexamination.find',
              'uses' => 'PatientExamination\PatientExaminationController@find',
          ]);
    Route::post('/', [
        'as' => 'api.patientexamination.store',
        'uses' => 'PatientExamination\PatientExaminationController@store',
    ]);

    Route::delete('/{patientexamination}', [
        'as' => 'api.patientexamination.destroy',
        'uses' => 'PatientExamination\PatientExaminationController@destroy',
    ]);
});
Route::middleware('auth:api')->prefix('/examinationservices')->group(function (){

    Route::get('/', [
        'as' => 'api.examinationservice.index',
        'uses' => 'ExaminationService\ExaminationServiceController@index',
    ]);
    Route::post('/{examinationservice}/edit', [
            'as' => 'api.examinationservice.update',
            'uses' => 'ExaminationService\ExaminationServiceController@update',
        ]);
   Route::get('/{examinationservice}', [
              'as' => 'api.examinationservice.find',
              'uses' => 'ExaminationService\ExaminationServiceController@find',
          ]);
    Route::post('/', [
        'as' => 'api.examinationservice.store',
        'uses' => 'ExaminationService\ExaminationServiceController@store',
    ]);

    Route::delete('/{examinationservice}', [
        'as' => 'api.examinationservice.destroy',
        'uses' => 'ExaminationService\ExaminationServiceController@destroy',
    ]);
});
// append









