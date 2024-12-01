<?php

namespace App\Http\Controllers;

use App\Models\ProjectRequirementDetail;
use Illuminate\Http\Request;

class ProjectRequirementDetailController extends Controller
{
    public function list_by_project_requirement($project_requirement_id){
        $project_requirement_details = ProjectRequirementDetail::where('project_requirement_id',$project_requirement_id)->get();
        return response()->json($project_requirement_details);
    }
}
