<?php

use App\Models\TablaFox;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

// Route::middleware('auth:api')->get('/user', function () {
//     return response()->json(Auth::user());
// });

Route::post('verify/login', 'Auth\AuthenticationController@login');

Route::group(
    [
        'middleware' => 'auth:api'
    ],
    function () {
       

Route::get('roles/list', 'RoleController@list');
Route::post('roles/store', 'RoleController@store');

// SYSTEM MODULES
Route::get('system-modules/list', 'SystemModuleController@list');


Route::get('users/list', 'UserController@list');
Route::post('users/store', 'UserController@store');
Route::post('users/update-password', 'UserController@updatePassword');


// USER SIR
Route::get('sir-users/list', 'UserSirController@list_dni');

// PERMISSIONS (PERMISSIONS , HAS_PERMISSIONS)
Route::get('permissions/list', 'PermissionController@index');
Route::post('permissions/update', 'PermissionController@update');
Route::post('permissions/update-permissions', 'PermissionController@update_permissions');
Route::get('permissions/list-by-role/{role_id}', 'PermissionController@permissions_by_role');


Route::get('job-titles/list', 'JobTitleController@list');
Route::get('job-titles/list-with-profiles', 'JobTitleController@list_with_profile');
Route::post('job-titles/store', 'JobTitleController@store');
Route::post('job-titles/update', 'JobTitleController@update');
Route::post('job-titles/delete', 'JobTitleController@destroy');
Route::get('job-titles/next-code', 'JobTitleController@next_code');

Route::get('job-profiles/list', 'JobProfileController@list');
Route::post('job-profiles/store', 'JobProfileController@store');
Route::post('job-profiles/update', 'JobProfileController@update');
Route::get('job-profiles/delete/{id}', 'JobProfileController@destroy');


Route::get('jobtitle-assigned/list-by-requirement-detail/{requirement_detail_id}', 'JobTitleAssignedController@list_project_requirement_detail');
Route::post('jobtitle-assigned/store', 'JobTitleAssignedController@store');


Route::post('people/find-sir','PersonController@find_on_sir');
Route::get('people/find-reniec/{dni}','PersonController@consultarDNI');

Route::get('employees/list', 'EmployeeController@list');
Route::get('employees/getone/{employee_id}', 'EmployeeController@get_one');
Route::post('employees/store', 'EmployeeController@store');
Route::post('employees/update', 'EmployeeController@update');
Route::get('employees/delete/{id}', 'EmployeeController@delete');

Route::get('project-requirements/list', 'ProjectRequirementController@list');
Route::get('project-requirements/freeze/{project_id}', 'ProjectRequirementController@freeze');
Route::post('project-requirements/store', 'ProjectRequirementController@store');
Route::post('project-requirements/update', 'ProjectRequirementController@update');
Route::get('project-requirements/delete/{id}', 'ProjectRequirementController@delete');
Route::post('project-requirements/real-saldo', 'ProjectRequirementController@real_saldo');

Route::get('project-requirement-details/delete/{id}', 'ProjectRequirementDetailController@delete');
Route::post('project-requirement-details/store', 'ProjectRequirementDetailController@store');
Route::post('project-requirement-details/update/no-rrhh', 'ProjectRequirementDetailController@update_no_rrhh');

Route::get('work-experiences/list/{employee_id}', 'WorkExperienceController@list');
Route::post('work-experiences/store', 'WorkExperienceController@store');
Route::post('work-experiences/update', 'WorkExperienceController@update');
Route::get('work-experiences/delete/{id}', 'WorkExperienceController@delete');

Route::get('academic-training/list/{employee_id}', 'AcademicTrainingController@list');
Route::post('academic-training/store', 'AcademicTrainingController@store');
Route::post('academic-training/update', 'AcademicTrainingController@update');
Route::get('academic-training/delete/{id}', 'AcademicTrainingController@delete');


Route::get('authorization-certificates/list-by-academic-training/{academic_training_id}', 'AuthorizationCertificateController@list_by_academic_training');
Route::post('authorization-certificates/store', 'AuthorizationCertificateController@store');
Route::get('authorization-certificates/delete/{id}', 'AuthorizationCertificateController@delete');

Route::get('training/list/{employee_id}', 'TrainingController@list');
Route::post('training/store', 'TrainingController@store');

Route::get('project-requirement-details/list-by-project-requirement/{project_requirement_id}', 'ProjectRequirementDetailController@list_by_project_requirement');
Route::post('project-requirement-details/update', 'ProjectRequirementDetailController@update');
Route::get('countries/list', 'CountryController@list');



Route::post('foxpro/find-by-expendspecific-secfunc', 'FoxProController@find_by_expendspecific_secfunc');
}
);
Route::get('executing-units/list', 'ExecutingUnitController@list');
