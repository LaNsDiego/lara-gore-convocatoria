<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AuthenticationController extends Controller
{
    public function login(){
        return response()->json([
            'message' => 'Login'
        ]);
    }
}
