<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Log;

class AuthenticationController extends Controller
{
    public function login(Request $request){
        Log::info($request->all());

        $user = User::where('usuario_dni',$request->dni)->first();
        if($user){
            return response()->json([
                'user' => $user,
                'message' => 'Usuario autorizado'
            ]);
        }else{
            return response()->json([
                'message' => 'Usuario no autorizado'
            ],404);
        }
        
    }
}
