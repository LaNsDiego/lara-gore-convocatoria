<?php

namespace App\Http\Controllers;

use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WorkExperienceController extends Controller
{
    public function list($employee_id){

        $entities = WorkExperience::with(['employee'])->where('employee_id',$employee_id)->get();
        return response()->json($entities);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer',
            'sector' => 'required|string|max:255',
            'experience_type' => 'required|string|max:255',
            'entity' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'functions_performed' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'document_name' => 'required|string|max:255',
        ]);
        $work_experience = new WorkExperience();
        $work_experience->employee_id = $request->employee_id;
        $work_experience->sector = $request->sector;
        $work_experience->experience_type = $request->experience_type;
        $work_experience->entity = $request->entity;
        $work_experience->job_title = $request->job_title;
        $work_experience->functions_performed = $request->functions_performed;
        $work_experience->start_date = $request->start_date;
        $work_experience->end_date = $request->end_date;
        $work_experience->document_name = $request->document_name;
        
        
        $work_experience->file = '';
        if($request->hasFile('file')){
            $photo = $request->file('file');
            $work_experience->file = $photo->store('experience','public');
        }
        $work_experience->save();

        return response()->json(['message' => 'Experiencia laboral registrada exitosamente'], Response::HTTP_OK);
    }
}
