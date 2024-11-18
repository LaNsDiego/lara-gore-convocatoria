<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function find_on_sir(Request $request){
        $person = Person::
            where('pers_cod',$request->document_number)
            // ->orWhere('')
            ->first();

        if($person){
            return response()->json([
                'message' => 'Persona encontrada',
                'person' => $person
            ]);
        }else{
            return response()->json([
                'message' => 'Persona no encontrada',
                'person' => null
            ],Response::HTTP_NOT_FOUND);
        }
    }
        
}
