<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class JobTitleController extends Controller
{
    public function list(Request $request)
    {
        $token = JWTAuth::fromUser(Auth::user());
        $payload = JWTAuth::setToken($token)->getPayload();
        $job_titles = JobTitle::where('executor_unit',$payload['executor_unit'])->get();
        return response()->json($job_titles);
    }

    public function list_with_profile()
    {
        
        $job_titles = JobTitle::with(['profiles'])->get();
        return response()->json($job_titles);
    }

    public function store(Request $request)
    {


        $request->validate([
            'code' => 'required',
            'name' => 'required',
            'status' => 'required',
            'executor_unit' => 'required',
        ]);

        JobTitle::create([
            'code' => $request->code,
            'name' => $request->name,
            'status' => $request->status,
            'executor_unit' => $request->executor_unit,
            'observation' => $request->observation ?? '',
        ]);
        
        return response()->json(['message' => 'El cargo fue registrado exitosamente'], Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:job_titles,id',
            'code' => 'required',
            'name' => 'required',
            'status' => 'required',
            'executor_unit' => 'required',
        ]);

        $job_title = JobTitle::find($request->id);
        $job_title->name = $request->name;
        $job_title->status = $request->status;
        $job_title->observation = $request->observation ?? '';
        $job_title->save();
        
        return response()->json(['message' => 'El cargo fue actualizada exitosamente' ], Response::HTTP_OK);
    }
    
    public function destroy(Request $request){

        $request->validate([
            'job_title_id' => 'required|integer|exists:job_titles,id',
        ]);
        $job_title = JobTitle::find($request->job_title_id);

        $job_title->delete();
        return response()->json(['message' => 'El cargo fue eliminada exitosamente' ], Response::HTTP_OK);
    }

    public function next_code(){
        $rmax = JobTitle::withTrashed()->max('id');
        $maxId = $rmax + 1;
        return response()->json(str_pad($maxId,3,'0',STR_PAD_LEFT));
    }
}