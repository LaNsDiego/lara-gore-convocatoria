<?php

namespace App\Http\Controllers;

use App\Models\ExecutingUnit;
use Illuminate\Http\Request;

class ExecutingUnitController extends Controller
{
    public function  list(){
        $units = ExecutingUnit::all();
        return response()->json($units);
    }
}
