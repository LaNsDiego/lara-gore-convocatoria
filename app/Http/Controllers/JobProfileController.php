<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class JobProfileController extends Controller
{
    public function list()
    {
        $profiles = Profile::with(['job_title'])->get();
        return response()->json($profiles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'job_title_id' => 'required|exists:job_titles,id',
            'request_name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        Profile::create([
            'job_title_id' => $request->job_title_id,
            'request_name' => $request->request_name,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        
        return response()->json(['message' => 'El cargo fue registrado exitosamente'], Response::HTTP_CREATED);
    }

    //TODO: Implement the update method
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:job_profiles,id',
            'job_title_id' => 'required|exists:job_titles,id',
            'request_name' => 'required',
            'description' => 'required',
            'status' => 'required',
        ]);

        $job_title = Profile::find($request->id);
        $job_title->name = $request->name;
        $job_title->save();
        
        return response()->json(['message' => 'El cargo fue actualizada exitosamente' ], Response::HTTP_OK);
    }
    

    //TODO: Implement the destroy method
    public function destroy(Request $request){

        $request->validate([
            'job_title_id' => 'required|integer|exists:job_titles,id',
        ]);
        $job_title = Profile::find($request->job_title_id);

        $job_title->delete();
        return response()->json(['message' => 'El cargo fue eliminada exitosamente' ], Response::HTTP_OK);
    }
}