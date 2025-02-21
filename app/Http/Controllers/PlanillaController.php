<?php

namespace App\Http\Controllers;

use App\Models\CategoriaMonto;
use App\Models\Planilla;
use App\Models\ProjectRequirementDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PlanillaController extends Controller
{
    public function list_params_regimen(){
        $categorias = CategoriaMonto::
            where('conlab_cod', 'L')
            ->where('estado', 'T')
            ->orderBy('categoria_cod', 'asc')
            ->orderBy('rubro_cod', 'asc')
            ->get();

        return response()->json($categorias);

        // where conlab_cod='L' and categoria_cod = 'O-I' and estado = 'T'
    }

    public function find_by_project_req_id($project_requirement_detail_id){
        $planilla = Planilla::where('project_requirement_detail_id',$project_requirement_detail_id)->first();
        return response()->json($planilla);
    }


    public function store(Request $request){
        Log::info($request->all());

        //find or create
        
        $planilla = Planilla::where('project_requirement_detail_id',$request->project_requirement_detail_id)->first();
        $planilla = $planilla ?? new Planilla();
        $planilla->is_civil = $request->is_civil;
        $planilla->project_requirement_detail_id = $request->project_requirement_detail_id;
        $planilla->dias_laborados = $request->dias_laborados;
        $planilla->cantidad_domingos = $request->cantidad_domingos;
        $planilla->cantidad_feriados = $request->cantidad_feriados;
        $planilla->hijos = $request->hijos;
        $planilla->jornal_diario = $request->jornal_diario;
        $planilla->remuneracion_basica = $request->remuneracion_basica;
        $planilla->buc = $request->buc;
        $planilla->vacaciones_truncas = $request->vacaciones_truncas;
        $planilla->cts = $request->cts;
        $planilla->movilidad = $request->movilidad;
        $planilla->escolaridad = $request->escolaridad;
        $planilla->jornal_dominical = $request->jornal_dominical;
        $planilla->gratificacion = $request->gratificacion;
        $planilla->bonificacion_l29714 = $request->bonificacion_l29714;
        $planilla->pago_feriado = $request->pago_feriado;
        $planilla->total_remuneracion = $request->total_remuneracion;
        $planilla->remuneracion_asegur = $request->remuneracion_asegur;
        $planilla->essalud = $request->essalud;
        $planilla->essalud_vida = $request->essalud_vida;
        $planilla->sctr = $request->sctr;
        $planilla->crecer_seg = $request->crecer_seg;
        $planilla->total_aportes = $request->total_aportes;
        $planilla->total = $request->total;
        $planilla->save();

        if($planilla->is_civil != 'ADMINISTRATIVO'){
            $detail = ProjectRequirementDetail::find($request->project_requirement_detail_id);
            $detail->amount_required = $request->total;
            $detail->total_amount = $request->total;
            $detail->essalud = 0;
            $detail->save();
        }else{
            $detail = ProjectRequirementDetail::find($request->project_requirement_detail_id);
            $detail->amount_required = 0;
            $detail->total_amount = 0;
            $detail->essalud = 0;
            $detail->save();
        }
        return response()->json(['message' => 'Planilla creada correctamente.']);
    }
}
