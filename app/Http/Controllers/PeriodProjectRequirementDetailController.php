<?php

namespace App\Http\Controllers;

use App\Models\PeriodRequirementDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PeriodProjectRequirementDetailController extends Controller
{
    public function list($project_requirement_detail_id){
        $periods = PeriodRequirementDetail::where('project_requirement_detail_id',$project_requirement_detail_id)->get();
        return response()->json($periods);
    }

    public function find_by_req_detail($project_requirement_detail_id){
        // $period = PeriodRequirementDetail::where('project_requirement_detail_id',$project_requirement_detail_id)->first();

        $currentMonth = Carbon::now()->format('F'); // Obtiene el mes actual en inglés

        $period = PeriodRequirementDetail::where('project_requirement_detail_id', $project_requirement_detail_id)
        ->where(function ($query) use ($currentMonth) {
            $query->whereRaw("? BETWEEN start_month_name AND end_month_name", [$currentMonth])
                  ->orWhere(function ($query) use ($currentMonth) {
                      // Maneja casos donde el periodo cruza el año (Ejemplo: Noviembre - Febrero)
                      $query->where('start_month_name', '>', 'end_month_name')
                            ->where(function ($query) use ($currentMonth) {
                                $query->where('start_month_name', '<=', $currentMonth)
                                      ->orWhere('end_month_name', '>=', $currentMonth);
                            });
                  });
        })
        ->first();

        if ($period) {

            // Convertimos la fecha usando el formato correcto (DD/MM/YYYY)
            $startDate = Carbon::createFromFormat('d/m/Y', $period->start_date);
            $endDate = Carbon::createFromFormat('d/m/Y', $period->end_date);
            $daysInPeriod = $startDate->diffInDays($endDate) + 1; // +1 para incluir el último día
    
            // Calcular la cantidad de domingos en el rango de fechas
            $sundaysCount = 0;
            $currentDate = clone $startDate;
            while ($currentDate->lte($endDate)) {
                if ($currentDate->dayOfWeek === Carbon::SUNDAY) {
                    $sundaysCount++;
                }
                $currentDate->addDay();
            }

            
            return response()->json([
                'period' => $period,
                'days_in_period' => $daysInPeriod,
                'sundays_count' => $sundaysCount
            ]);
        }

        
        return response()->json($period);
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
