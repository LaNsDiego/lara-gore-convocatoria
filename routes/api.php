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


Route::post('verify/login', 'Auth\AuthenticationController@login');

Route::get('job-titles/list', 'JobTitleController@list');
Route::get('job-titles/list-with-profiles', 'JobTitleController@list_with_profile');
Route::post('job-titles/store', 'JobTitleController@store');
Route::post('job-titles/update', 'JobTitleController@update');
Route::post('job-titles/delete', 'JobTitleController@destroy');
Route::get('job-titles/next-code', 'JobTitleController@next_code');

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
Route::post('project-requirements/update', 'ProjectRequirementController@update');
Route::post('project-requirements/real-saldo', 'ProjectRequirementController@real_saldo');

Route::get('work-experiences/list/{employee_id}', 'WorkExperienceController@list');
Route::post('work-experiences/store', 'WorkExperienceController@store');
Route::post('work-experiences/update', 'WorkExperienceController@update');
Route::get('work-experiences/delete/{id}', 'WorkExperienceController@delete');

Route::get('academic-training/list/{employee_id}', 'AcademicTrainingController@list');
Route::post('academic-training/store', 'AcademicTrainingController@store');
Route::post('academic-training/update', 'AcademicTrainingController@update');

Route::get('training/list/{employee_id}', 'TrainingController@list');
Route::post('training/store', 'TrainingController@store');

Route::get('project-requirement-details/list-by-project-requirement/{project_requirement_id}', 'ProjectRequirementDetailController@list_by_project_requirement');
Route::post('project-requirement-details/update', 'ProjectRequirementDetailController@update');
Route::get('countries/list', 'CountryController@list');

Route::get('executing-units/list', 'ExecutingUnitController@list');


Route::post('foxpro/find-by-expendspecific-secfunc', 'FoxProController@find_by_expendspecific_secfunc');
Route::get('gastos',function (){
    // phpinfo();
    // return PHP_INT_SIZE * 8 . " bits";
    // TablaFox::all();
    // $cnx = odbc_connect('Driver={Microsoft Visual FoxPro Driver};SourceType=DBC;SourceDB=\\127.0.0.1\\binsweb\\siaf\\siaf.dbc;Exclusive=No;', '', '');
    $cnx = odbc_connect('Driver={Microsoft Visual FoxPro Driver};SourceType=DBC;SourceDB=C:\Users\dvans\Documents\siaf\SIAF.DBC;Exclusive=No;NULL=NO;', '', '');
    // $cnx = odbc_connect('Driver=vfpoledb;SourceType=DBC;SourceDB=C:\Users\dvans\Documents\siaf\SIAF.DBC;Exclusive=No;NULL=NO;', '', '');
    // $cnx = odbc_connect('siafdbc', '', '');

    if(!$cnx){
        return response()->json([
            'message' => 'No se pudo conectar a la base de datos'
        ]);
    }

    $especific = "3.8.1.4.1";
    $parts = explode('.', $especific);

    $ano_eje = '2024';
    $tipo_transaccion = '2';
    $generica = '6';
    $subgenerica = '8';
    $subgenerica_det = '1';
    $especifica = '4';
    $especifica_det = '1';
    $data = [];

    // Consulta a ejecutar
    $sql = "SELECT * FROM act_proy_nombre WHERE ano_eje='2024' AND act_proy=
    (SELECT act_proy FROM meta WHERE ano_eje='2024' AND sec_ejec='000931' AND sec_func='0770')"; // Cambia 'tu_tabla' por el nombre de tu tabla
    // $sql = "SELECT id_clasificador FROM especifica_det WHERE ano_eje='2024' AND tipo_transaccion='2' AND generica='6' AND subgenerica=' 8' AND subgenerica_det=' 1' AND especifica=' 4' AND ALLTRIM(especifica_det)='1'";

    // Ejecutar la consulta
    $resultado = @odbc_exec($cnx, $sql);

    if (!$resultado) {
        die("Error en la consulta: " . odbc_errormsg());
    }  

    // Obtener resultados
    while ($fila = odbc_fetch_array($resultado)) {
        array_push($data,$fila); // Imprime cada fila como un array asociativo
    }

    return response()->json([
        'message' => $data ,
    ]);
});
