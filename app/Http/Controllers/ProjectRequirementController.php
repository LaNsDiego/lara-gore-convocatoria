<?php

namespace App\Http\Controllers;

use App\Models\ProjectRequirement;
use App\Models\ProjectRequirementDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProjectRequirementController extends Controller
{

    public function list(){
        $token = JWTAuth::fromUser(Auth::user());
        $payload = JWTAuth::setToken($token)->getPayload();
        
        if($payload['user']['role_id'] != '1'){
            $project_requirements = ProjectRequirement::
                whereHas('assignations', function($query) use ($payload) {
                    $query->where('user_id',$payload['user']['id']);
                })
                ->where('executor_unit',$payload['executor_unit'])
            ->get();
            return response()->json($project_requirements);
        }

        return response()->json(
            ProjectRequirement::get()
        );


        
    }
    public function store(Request $request){
        $request->validate([
            'functional_sequence' => 'required|string',
            'specific_expenditure' => 'required|string',
            'project_name' => 'required|string',
            'amount_as_specified' => 'required|numeric',
            'dni_responsible' => 'required|string',
            'full_name_responsible' => 'required|string',
            'document_type' => 'required|string',
            'document_number' => 'required|string',
            'employeeRequirements' => 'required|array',
            'executor_unit' => 'required',
        ]);

        $token = JWTAuth::fromUser(Auth::user());
        $payload = JWTAuth::setToken($token)->getPayload();

        $new = new ProjectRequirement();
        $new->functional_sequence = $request->functional_sequence;
        $new->specific_expenditure = $request->specific_expenditure;
        $new->project_name = $request->project_name;
        $new->amount_as_specified = $request->amount_as_specified;
        $new->dni_responsible = $request->dni_responsible;
        $new->full_name_responsible = $request->full_name_responsible;
        $new->document_type = $request->document_type;
        $new->document_number = $request->document_number;
        $new->executor_unit = $payload['executor_unit'];
        $new->save();

        $details = $request->employeeRequirements;
        foreach ($details as $detail) {
            $project_req_detail = new ProjectRequirementDetail();
            $project_req_detail->dni = $detail['dni'];
            $project_req_detail->first_name = $detail['first_name'];
            $project_req_detail->father_last_name = $detail['father_last_name'];
            $project_req_detail->mother_last_name = $detail['mother_last_name'];
            $project_req_detail->amount_required = $detail['amount_required'];
            $project_req_detail->amount_rrhh = 0;
            $project_req_detail->observation = '';
            $project_req_detail->project_requirement_id = $new->id;
            $project_req_detail->save();
        }

        return response()->json([
            'message' => 'Project Requirement created successfully',
        ], 201);
    }

    public function update(Request $request){
        $request->validate([
            'id' => 'required|integer|exists:project_requirements,id',
            'functional_sequence' => 'required|string',
            'specific_expenditure' => 'required|string',
            'project_name' => 'required|string',
            'amount_as_specified' => 'required|numeric',
            'dni_responsible' => 'required|string',
            'full_name_responsible' => 'required|string',
            'document_type' => 'required|string',
            'document_number' => 'required|string',
            'employeeRequirements' => 'required|array',
        ]);

        $new = ProjectRequirement::find($request->id);

        $details = $request->employeeRequirements;
        foreach ($details as $detail) {

            if (!property_exists((object)$detail, 'id')) {
                $project_req_detail = new ProjectRequirementDetail();
                $project_req_detail->dni = $detail['dni'];
                $project_req_detail->first_name = $detail['first_name'];
                $project_req_detail->father_last_name = $detail['father_last_name'];
                $project_req_detail->mother_last_name = $detail['mother_last_name'];
                $project_req_detail->amount_required = $detail['amount_required'];
                $project_req_detail->amount_rrhh = 0;
                $project_req_detail->observation = '';
                $project_req_detail->project_requirement_id = $new->id;
                $project_req_detail->save();
            }
        }

        return response()->json([
            'message' => 'Project Requirement created successfully',
        ], 200);
        // return response()->json([
        //     'message' => 'Project Requirement created successfully',
        // ], 500);
    }

    public function real_saldo(Request $request){
        $project = ProjectRequirement::
            where('specific_expenditure',$request->specific_expenditure)
            ->where('functional_sequence',$request->functional_sequence)
            ->get();
        if(count($project) > 0){

            //foreach for sum details of projects
            $total = $project->map(function($item){
                $amount_required_used = ProjectRequirementDetail::
                    where('project_requirement_id', $item->id)
                    ->where('deleted_at', null)
                    ->get()
                    ->reduce(function ($carry, $detail) {
                        return $carry + ($detail->amount_rrhh == 0 ? $detail->amount_required : $detail->amount_rrhh);
                    }, 0);
                $item->amount_as_specified_2 = floatval($amount_required_used);
                return $item;
            })->sum('amount_as_specified_2');
            return response()->json([ 'amount_as_specified' => floatval($project[0]->amount_as_specified) - $total ]);
        }

        return response()->json([
            'message' => 'Al parecer es el primer proyecto con este código',
        ], 404);
    }

    public function freeze($project_id) {
        $project = ProjectRequirement::find($project_id);
        $project->is_freeze = true;
        $project->save();
        return response()->json([
            'message' => 'Projecto cerrado correctamente',
        ], 200);
    }

        
    public function delete(Request $request , $id){

        $project = ProjectRequirement::find($id);
        $project->delete();
        return response()->json(['message' => 'El cargo fue eliminada exitosamente' ], Response::HTTP_OK);
    }
}
