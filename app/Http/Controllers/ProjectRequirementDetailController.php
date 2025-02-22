<?php

namespace App\Http\Controllers;

use App\Models\CargoSir;
use App\Models\ProjectRequirementDetail;
use Illuminate\Http\Request;

class ProjectRequirementDetailController extends Controller
{
    public function list_by_project_requirement($project_requirement_id){
        $project_requirement_details = ProjectRequirementDetail::
        with(['planilla','job_title_assigned'])
        ->where('project_requirement_id',$project_requirement_id)
        ->get()
        ->map(function($project_requirement_detail){
            if($project_requirement_detail->job_title_assigned != null){
                $project_requirement_detail->job_title = CargoSir::where('id_cargo',$project_requirement_detail->job_title_assigned->job_title_id)->first();
            }
           
            return $project_requirement_detail;
        });
        return response()->json($project_requirement_details);
    }

    public function store(Request $request){
        $request->validate([
            'dni' => 'required|string',
            'first_name' => 'required|string',
            'father_last_name' => 'required|string',
            'mother_last_name' => 'required|string',
            'amount_required' => 'required|numeric',
            'project_requirement_id' => 'required|numeric',
        ]);
        $project_requirement_detail = new ProjectRequirementDetail();
        $project_requirement_detail->dni = $request->dni;
        $project_requirement_detail->first_name = $request->first_name;
        $project_requirement_detail->father_last_name = $request->father_last_name;
        $project_requirement_detail->mother_last_name = $request->mother_last_name;
        $project_requirement_detail->amount_required = $request->amount_required;
        $project_requirement_detail->amount_rrhh = 0;
        $project_requirement_detail->observation = '';
        $project_requirement_detail->essalud = floatval($request->amount_required) * 0.09;
        $project_requirement_detail->total_amount = floatval($request->amount_required) * 0.09 + floatval($request->amount_required);
        $project_requirement_detail->project_requirement_id = $request->project_requirement_id;
        $project_requirement_detail->save();
        return response()->json(['message' => 'Requerimiento detalle creado correctamente']);
    }

    public function update(Request $request){
        $request->validate([
            'id' => 'required',
            'amount_rrhh' => 'required|numeric',
        ]);
        $project_requirement_detail = ProjectRequirementDetail::find($request->id);
        $project_requirement_detail->amount_rrhh = floatval($request->amount_rrhh) ;
        $project_requirement_detail->observation = $request->observation ?? '';
        $project_requirement_detail->essalud = floatval($request->amount_rrhh) * 0.09;
        $project_requirement_detail->total_amount = floatval($request->amount_rrhh) * 0.09 + floatval($request->amount_rrhh);
        $project_requirement_detail->save();
        return response()->json(['message' => 'Requerimiento actualizado correctamente']);
    }

    public function update_no_rrhh(Request $request){
        $request->validate([
            'id' => 'required',
            'amount_required' => 'required|numeric',
        ]);
        $project_requirement_detail = ProjectRequirementDetail::find($request->id);
        $project_requirement_detail->amount_required = $request->amount_required;
        $project_requirement_detail->save();
        return response()->json(['message' => 'Requerimiento actualizado correctamente']);
    }

    public function delete($id){
        $project_requirement_detail = ProjectRequirementDetail::find($id);
        if ($project_requirement_detail) {
            $project_requirement_detail->delete();
            return response()->json(['message' => 'Requerimiento eliminado correctamente']);
        } else {
            return response()->json(['message' => 'Requerimiento no encontrado'], 404);
        }
    }
}
