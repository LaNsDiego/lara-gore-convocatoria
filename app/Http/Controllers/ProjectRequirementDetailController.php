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

    public function update(Request $request){
        $request->validate([
            'id' => 'required',
            'amount_rrhh' => 'required|numeric',
        ]);
        $project_requirement_detail = ProjectRequirementDetail::find($request->id);
        $project_requirement_detail->amount_rrhh = $request->amount_rrhh;
        $project_requirement_detail->observation = $request->observation ?? '';
        $project_requirement_detail->save();
        return response()->json(['message' => 'Requerimiento actualizado correctamente']);
    }
}
