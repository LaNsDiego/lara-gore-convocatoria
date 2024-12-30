<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class JobProfileController extends Controller
{
    public function list()
    {
        $token = JWTAuth::fromUser(Auth::user());
        $payload = JWTAuth::setToken($token)->getPayload();
        $profiles = Profile::where('executor_unit',$payload['executor_unit'])->with(['job_title'])->get();
        return response()->json($profiles);
    }

    public function list_by_cargo_sir($cargo_sir){
        $profiles = Profile::where('job_title_id',$cargo_sir)->get();
        return response()->json($profiles);
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'job_title_id' => 'required|exists:job_titles,id',
            'job_title_id' => 'required',
            'request_name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'executor_unit' => 'required',
        ]);

        Profile::create([
            'job_title_id' => $request->job_title_id,
            'request_name' => $request->request_name,
            'description' => $request->description,
            'status' => $request->status,
            'executor_unit' => $request->executor_unit,
        ]);
        
        return response()->json(['message' => 'El cargo fue registrado exitosamente'], Response::HTTP_CREATED);
    }

    
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:profiles,id',
            'job_title_id' => 'required|exists:job_titles,id',
            'request_name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $job_title = Profile::find($request->id);
        $job_title->request_name = $request->request_name;
        $job_title->description = $request->description;
        $job_title->status = $request->status;
        $job_title->save();
        
        return response()->json(['message' => 'El cargo fue actualizada exitosamente' ], Response::HTTP_OK);
    }
    

    public function destroy(Request $request , $id){
        $job_title = Profile::find($id);
        $job_title->delete();
        return response()->json(['message' => 'El cargo fue eliminada exitosamente' ], Response::HTTP_OK);
    }
}