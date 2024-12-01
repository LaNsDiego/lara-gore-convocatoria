<?php

namespace App\Http\Controllers;

use App\Models\ProjectRequirement;
use App\Models\ProjectRequirementDetail;
use Illuminate\Http\Request;

class ProjectRequirementController extends Controller
{

    public function list(){
        return response()->json(ProjectRequirement::all());
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
        ]);

        $new = new ProjectRequirement();
        $new->functional_sequence = $request->functional_sequence;
        $new->specific_expenditure = $request->specific_expenditure;
        $new->project_name = $request->project_name;
        $new->amount_as_specified = $request->amount_as_specified;
        $new->dni_responsible = $request->dni_responsible;
        $new->full_name_responsible = $request->full_name_responsible;
        $new->document_type = $request->document_type;
        $new->document_number = $request->document_number;
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
}
