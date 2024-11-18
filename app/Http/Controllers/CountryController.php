<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function list(){
        $countries = Country::with(['departments.provincies.cities'])->get();
        return response()->json($countries);
    }
}
