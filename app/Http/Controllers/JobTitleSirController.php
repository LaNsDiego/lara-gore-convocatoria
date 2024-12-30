<?php

namespace App\Http\Controllers;

use App\Models\CargoSir;
use Illuminate\Http\Request;

class JobTitleSirController extends Controller
{
    public function list(){
        $cargos = CargoSir::all();
        return response()->json($cargos);
    }

    // public function list_with_profile()
    // {
        
    //     $job_titles = CargoSir::with(['profiles'])->get();
    //     return response()->json($job_titles);
    // }
}
