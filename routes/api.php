<?php

use App\Models\TablaFox;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('roles/list', 'RoleController@list');
Route::post('roles/store', 'RoleController@store');

// SYSTEM MODULES
Route::get('system-modules/list', 'SystemModuleController@list');

// PERMISSIONS (PERMISSIONS , HAS_PERMISSIONS)
Route::get('permissions/list', 'PermissionController@index');
Route::post('permissions/update', 'PermissionController@update');
Route::post('permissions/update-permissions', 'PermissionController@update_permissions');
Route::get('permissions/list-by-role/{role_id}', 'PermissionController@permissions_by_role');


Route::post('verify/login', 'Auth\AuthenticationController@login');

Route::get('job-titles/list', 'JobTitleController@list');
Route::get('job-titles/list-with-profiles', 'JobTitleController@list_with_profile');
Route::post('job-titles/store', 'JobTitleController@store');
Route::post('job-titles/update', 'JobTitleController@update');
Route::post('job-titles/delete', 'JobTitleController@destroy');

Route::get('job-profiles/list', 'JobProfileController@list');
Route::post('job-profiles/store', 'JobProfileController@store');
Route::post('job-profiles/update', 'JobProfileController@update');
Route::post('job-profiles/delete', 'JobProfileController@destroy');


Route::get('jobtitle-assigned/list-by-requirement-detail/{requirement_detail_id}', 'JobTitleAssignedController@list_project_requirement_detail');
Route::post('jobtitle-assigned/store', 'JobTitleAssignedController@store');


Route::post('people/find-sir','PersonController@find_on_sir');
Route::get('people/find-reniec/{dni}','PersonController@consultarDNI');

Route::get('employees/list', 'EmployeeController@list');
Route::get('employees/getone/{employee_id}', 'EmployeeController@get_one');
Route::post('employees/store', 'EmployeeController@store');
Route::post('employees/update', 'EmployeeController@update');

Route::get('project-requirements/list', 'ProjectRequirementController@list');
Route::post('project-requirements/store', 'ProjectRequirementController@store');

Route::get('work-experiences/list/{employee_id}', 'WorkExperienceController@list');
Route::post('work-experiences/store', 'WorkExperienceController@store');
Route::post('work-experiences/update', 'WorkExperienceController@update');

Route::get('academic-training/list/{employee_id}', 'AcademicTrainingController@list');
Route::post('academic-training/store', 'AcademicTrainingController@store');
Route::post('academic-training/update', 'AcademicTrainingController@update');

Route::get('training/list/{employee_id}', 'TrainingController@list');
Route::post('training/store', 'TrainingController@store');

Route::get('project-requirement-details/list-by-project-requirement/{project_requirement_id}', 'ProjectRequirementDetailController@list_by_project_requirement');
Route::get('countries/list', 'CountryController@list');

Route::get('executing-units/list', 'ExecutingUnitController@list');

Route::get('gastos',function (){
    // phpinfo();

    $cnx = odbc_connect('Driver={Driver para o Microsoft Visual FoxPro};SourceType=DBC;SourceDB=C:\binsweb\siaf\SIAF.DBC;Exclusive=No;', '', '');

    if(!$cnx){
        return response()->json([
            'message' => 'No se pudo conectar a la base de datos'
        ]);
    }
    return response()->json([
        'message' => 'Conexión exitosa',
        // 'cnx' => $connection
        // 'data' => TablaFox::all()
        // 'data' => DB::connection('foxpro')->select('SELECT * FROM gasto')
    ]);
});
