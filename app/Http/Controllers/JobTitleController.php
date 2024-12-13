<?php

namespace App\Http\Controllers;

use App\Models\JobTitle;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class JobTitleController extends Controller
{
    public function list()
    {
        $job_titles = JobTitle::all();
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
            // 'observation' => 'required',
        ]);

        JobTitle::create([
            'code' => $request->code,
            'name' => $request->name,
            'status' => $request->status,
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
            'observation' => 'required',
        ]);

        $job_title = JobTitle::find($request->id);
        $job_title->name = $request->name;
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
        $maxId = JobTitle::max('id') + 1;
        return response()->json(str_pad($maxId,3,'0',STR_PAD_LEFT));
    }
}