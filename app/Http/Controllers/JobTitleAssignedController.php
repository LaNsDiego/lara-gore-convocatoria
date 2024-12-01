<?php

namespace App\Http\Controllers;

use App\Models\JobTitleAssigned;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class JobTitleAssignedController extends Controller
{
    public function list(){

    }

    public function store(Request $request){

        $entity = JobTitleAssigned::
            where('project_requirement_detail_id',$request->project_requirement_detail_id)
            ->where('job_title_id',$request->jobtitle_id)
            ->first();
        if($entity){
            $entity->selected_profiles = json_encode(array_map('utf8_encode', $request->selected_profiles));
            $entity->save();    
            return response()->json([
                'message' => 'La Asignacion de cargo fue actualizado exitosamente',
            ], 200);
        }
        $entity = new JobTitleAssigned();
        $entity->project_requirement_detail_id = $request->project_requirement_detail_id;
        $entity->job_title_id = $request->jobtitle_id;
        $entity->selected_profiles = json_encode(array_map('utf8_encode', $request->selected_profiles));
        $entity->save();

        return response()->json([
            'message' => 'Cargo asignado asignado exitosamente',
        ], 201);

        // Log::info($request->all());
        // Log::info($new);

        // return response()->json([
        //     'message' => 'Cargo asignado asignado exitosamente',
        // ], 500);
    }

    public function list_project_requirement_detail($requirement_detail_id){
        $jobtitle_assigned = JobTitleAssigned::where('project_requirement_detail_id', $requirement_detail_id)->first();
        Log::info("##### requirement_detail_id ####");
        Log::info($jobtitle_assigned);
        
        Log::info("--------------------------");
        return response()->json($jobtitle_assigned);
    }
}
