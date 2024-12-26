<?php

namespace App\Http\Controllers;

use App\Models\AcademicTraining;
use App\Models\AuthorizationCertificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AcademicTrainingController extends Controller
{
    public function list($employee_id){

        $entities = AcademicTraining::
            with(['employee','authorization_certificates','academic_situation_city.province.department.country'])
            ->where('employee_id', $employee_id)
            ->get();
        return response()->json($entities);
    }

    public function store(Request $request){

        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'educational_level' => 'required|string',
            'education_country_id' => 'required|string',
            'education_study_center' => 'required|string',
            'academic_situation' => 'required|string',
            'academic_situation_start_year' => 'required|string',
            'academic_situation_end_year' => 'required|string',
            'academic_situation_city_id' => 'required|string',

        ]);
        $academic_training = new AcademicTraining();
        $academic_training->employee_id = $request->employee_id;
        $academic_training->educational_level = $request->educational_level;
        $academic_training->education_country_id = $request->education_country_id;
        $academic_training->education_study_center = $request->education_study_center;
        $academic_training->academic_situation = $request->academic_situation;
        $academic_training->academic_situation_start_year = $request->academic_situation_start_year;
        $academic_training->academic_situation_end_year = $request->academic_situation_end_year;
        $academic_training->academic_situation_city_id = $request->academic_situation_city_id;
        $academic_training->academic_degree = $request->academic_degree ?? '';
        $academic_training->academic_degree_level = $request->academic_degree_level?? '';
        $academic_training->academic_degree_specialty = $request->academic_degree_specialty?? '';
        $academic_training->qualification_title = $request->qualification_title?? '';
        $academic_training->qualification_specialty = $request->qualification_specialty?? '';
        $academic_training->qualification_expedition_date = $request->qualification_expedition_date ?? '';
        $academic_training->qualification_entity_control = $request->qualification_entity_control?? '';
        $academic_training->qualification_registration_center = $request->qualification_registration_center?? '';
        $academic_training->qualification_registration_number = $request->qualification_registration_number?? '';
        $academic_training->qualification_registration_date = $request->qualification_registration_date?? '';
        $academic_training->qualification_resolution_date = $request->qualification_resolution_date?? '';
        $academic_training->qualification_resolution_number = $request->qualification_resolution_number?? '';

        $academic_training->qualification_file = '';
        if($request->hasFile('qualification_file')){
            $photo = $request->file('qualification_file');
            $academic_training->qualification_file = $photo->store('qualification_file','public');
        }

        $academic_training->tuition_school = $request->tuition_school?? '';
        $academic_training->tuition_number = $request->tuition_number?? '';
        $academic_training->tuition_date = $request->tuition_date?? '';
        $academic_training->tuition_file = $request->tuition_file?? '';
        $academic_training->tuition_file = '';
        if($request->hasFile('tuition_file')){
            $photo = $request->file('tuition_file');
            $academic_training->tuition_file = $photo->store('tuition_file','public');
        }

        $academic_training->save();



        $files = $request->file('authorization_certificates_files');
        for ($i = 0; $i < count($request->authorization_certificates_files); $i++) {
            $authorization_certificate = $request->authorization_certificates_certicates[$i];
            $authorization_start_date = $request->authorization_certificates_start_dates[$i];
            $authorization_end_date = $request->authorization_certificates_end_dates[$i];
            

            $authorization_cert_entity = new AuthorizationCertificate();
            $authorization_cert_entity->academic_training_id = $academic_training->id;
            $authorization_cert_entity->authorization_certificate = $authorization_certificate;
            $authorization_cert_entity->authorization_start_date = $authorization_start_date;
            $authorization_cert_entity->authorization_end_date = $authorization_end_date;
                
            $authorization_cert_entity->authorization_file = $files[$i]->store('authorization_file','public');
            
            $authorization_cert_entity->save();
        }

        return response()->json(['message' => 'Academic training saved successfully'], 200);
    }

    public function update(Request $request){

        $request->validate([
            'id' => 'required|exists:academic_trainings,id',
            'employee_id' => 'required|exists:employees,id',
            'educational_level' => 'required|string',
            'education_country_id' => 'required|string',
            'education_study_center' => 'required|string',
            'academic_situation' => 'required|string',
            'academic_situation_start_year' => 'required|string',
            'academic_situation_end_year' => 'required|string',
            'academic_situation_city_id' => 'required|string',

        ]);

        Log::info($request->all());
        $academic_training = AcademicTraining::find($request->id);
        $academic_training->employee_id = $request->employee_id;
        $academic_training->educational_level = $request->educational_level;
        $academic_training->education_country_id = $request->education_country_id;
        $academic_training->education_study_center = $request->education_study_center;
        $academic_training->academic_situation = $request->academic_situation;
        $academic_training->academic_situation_start_year = $request->academic_situation_start_year;
        $academic_training->academic_situation_end_year = $request->academic_situation_end_year;
        $academic_training->academic_situation_city_id = $request->academic_situation_city_id;
        $academic_training->academic_degree = $request->academic_degree ?? '';
        $academic_training->academic_degree_level = $request->academic_degree_level?? '';
        $academic_training->academic_degree_specialty = $request->academic_degree_specialty?? '';
        $academic_training->qualification_title = $request->qualification_title?? '';
        $academic_training->qualification_specialty = $request->qualification_specialty?? '';
        $academic_training->qualification_expedition_date = $request->qualification_expedition_date?? '';
        $academic_training->qualification_entity_control = $request->qualification_entity_control?? '';
        $academic_training->qualification_registration_center = $request->qualification_registration_center?? '';
        $academic_training->qualification_registration_number = $request->qualification_registration_number?? '';
        $academic_training->qualification_registration_date = $request->qualification_registration_date?? '';
        $academic_training->qualification_resolution_date = $request->qualification_resolution_date?? '';
        $academic_training->qualification_resolution_number = $request->qualification_resolution_number?? '';

        $academic_training->qualification_file = '';
        if($request->hasFile('qualification_file') && $request->file('qualification_file')->getClientMimeType() !== 'image/*' ){
            $photo = $request->file('qualification_file');
            $academic_training->qualification_file = $photo->store('qualification_file','public');
        }

        $academic_training->tuition_school = $request->tuition_school?? '';
        $academic_training->tuition_number = $request->tuition_number?? '';
        $academic_training->tuition_date = $request->tuition_date?? '';
        $academic_training->tuition_file = $request->tuition_file?? '';
        $academic_training->tuition_file = '';
        if($request->hasFile('tuition_file') && $request->file('tuition_file')->getClientMimeType() !== 'image/*'){
            $photo = $request->file('tuition_file');
            $academic_training->tuition_file = $photo->store('tuition_file','public');
        }

        $academic_training->save();



        return response()->json(['message' => 'Academic training saved successfully'], 200);
    }

    public function delete($id){
        $academic_training = AcademicTraining::find($id);
        $academic_training->delete();
        return response()->json(['message' => 'Formación academica borrada correctamente'], 200);
    }
}
