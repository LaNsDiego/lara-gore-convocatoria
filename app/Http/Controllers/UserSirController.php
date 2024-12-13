<?php

namespace App\Http\Controllers;

use App\Models\UserSir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserSirController extends Controller
{
    public function list_dni(){
        $users = UserSir::all();
        return response()->json($users);
    }
}
