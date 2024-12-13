<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

        $isSamePWD = Hash::check(
            $request->password,
            $user_dni->password
        );

        // if (!$token = JWTAuth::attempt($credentials)) {
        //     return response()->json(['error' => 'Credenciales inválidas'], 401);
        // }

        if(!$token = JWTAuth::claims(['user' => $user_dni])->attempt(['dni' => $request->dni, 'password' => $request->password])){

            return response()->json([
                'message' => 'Usuario no autorizado'
            ],404);
            
        }

        // return response()->json([
        //     'access_token' => $token,
        //     'token_type' => 'bearer',
        //     'expires_in' => auth('api')->factory()->getTTL() * 60 * 24,
        //     'role' => $role,
        // ]);
        
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
