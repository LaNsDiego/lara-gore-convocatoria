<?php

namespace App\Http\Controllers;

use App\Models\PeriodRequirementDetail;
use Illuminate\Http\Request;

class PeriodProjectRequirementDetailController extends Controller
{
    public function list($project_requirement_detail_id){
        $periods = PeriodRequirementDetail::where('project_requirement_detail_id',$project_requirement_detail_id)->get();
        return response()->json($periods);
    }

    public function store(Request $request){
        $period = new PeriodRequirementDetail();
        $period->project_requirement_detail_id = $request->project_requirement_detail_id;
        $period->year = $request->year;
        $period->start_date = $request->start_date;
        $period->end_date = $request->end_date;
        $period->start_month_name = $request->start_month_name;
        $period->end_month_name = $request->end_month_name;
        $period->observation = $request->observation ?? '';
        $period->save();
        return response()->json(['message' => 'Periodo creado correctamente']);
    }

    public function delete($id){
        $period = PeriodRequirementDetail::find($id);
        $period->delete();
        return response()->json(['message' => 'Periodo eliminado correctamente']);
    }
}
