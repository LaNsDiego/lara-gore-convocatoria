<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function list(){
        return response()->json(User::with(['role'])->get());
    }

    public function store(Request $request){
        $request->validate([
            // 'name','dni', 'email', 'password', 'role_id'
            'name' => 'required',
            'dni' => 'required|max:8|min:8',
            'email' => 'required|email',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->dni = $request->dni;
        $user->email = $request->email;
        $user->role_id = $request->role_id;
        // $user->password = bcrypt('123123123');
        $user->password = Hash::make("123123123");
        $user->save();

        return response()->json(['message' => 'Usuario creado correctamente'],201);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);

        $user = User::find($request->user_id);
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => "La contraseña fue actualizada exitosamente."], 201);
    }
}
