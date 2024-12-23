<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationController extends Controller
{
    public function login(Request $request){
        $user_dni = User::with(['role'])
        ->where('dni',$request->dni)->first();
        if(!$user_dni){
            return response()->json([
                'message' => 'DNI no encontrado'
            ],404);
        }
        

        $user_dni->executor_unit = $request->executing_unit;
        if(!$token = JWTAuth::claims(['user' => $user_dni , 'executor_unit' => $request->executing_unit  ])->attempt(['dni' => $request->dni, 'password' => $request->password])){

            return response()->json([
                'message' => 'Usuario no autorizado'
            ],404);
            
        }
        
        $role = Role::with(['permissions.permission.system_module.module_group'])->where('id', $user_dni->role_id)->first();
        
        return response()->json([
            'user' => $user_dni,
            // 'expires_in' => auth('api')->factory()->getTTL() * 60 * 24,
            'token_type' => 'bearer',
            'access_token' => $token,
            'role' => $role,
        ]);
        
        
        
    }
}
