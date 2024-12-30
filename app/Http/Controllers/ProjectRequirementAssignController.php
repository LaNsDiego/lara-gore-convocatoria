<?php

namespace App\Http\Controllers;

use App\Models\ProjectRequirementAssigned;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use stdClass;

class ProjectRequirementAssignController extends Controller
{

    public function list_user_availables($project_requeriment_id){
        // $excludes = ProjectRequirementAssigned::where('project_requeriment_id',$project_requirement_id)
        //     ->pluck('user_id');

        $excludes = ProjectRequirementAssigned::
            where('project_requeriment_id',$project_requeriment_id)
            ->pluck('user_id');

        $excluded_trashed = ProjectRequirementAssigned::onlyTrashed()
            ->where('project_requeriment_id',$project_requeriment_id)
            ->get();
            // ->pluck('user_id');
            
        $users = User::whereNotIn('id',$excludes)
            ->get()
            ->map(function($user) use($excluded_trashed,$project_requeriment_id){
                $assigned = new stdClass();
                $result = $excluded_trashed->filter(function($row) use($user){
                    return $row->user_id == $user->id;
                })->values();
                
                // Log::info("-------------------");
                // Log::info($result);
                if(count($result) == 1){
                    $assigned->id = $result[0]->id;
                }else{
                    $assigned->id = 0;
                }

                $assigned->user_id = $user->id;
                $assigned->name = $user->name;
                $assigned->project_requeriment_id = $project_requeriment_id;
                return $assigned;
            });
            // Log::info("--------USERS-------");
            // Log::info($users);
        return response()->json($users);
        // return response()->json([]);
    }

    public function list_by_project_requirement($project_requirement_id){
        $project_requirement_assigneds = ProjectRequirementAssigned::
            with(['user'])
            ->where('project_requeriment_id',$project_requirement_id)
            ->get();
        return response()->json($project_requirement_assigneds);
    }

    public function store(Request $request){

        
        $request->validate([
            'users.*.project_requeriment_id' => 'required',
            'users.*.user_id' => 'required',
        ]);

        Log::info($request->users);
        foreach($request->users as $assigned){
            
            if($assigned['id'] == 0){

                $new = new ProjectRequirementAssigned();
                $new->project_requeriment_id = $assigned['project_requeriment_id'];
                $new->user_id = $assigned['user_id'];
                $new->save();
            }else{
                $existing = ProjectRequirementAssigned::withTrashed()->where('id',$assigned['id'])->first();
                if ($existing) {
                    $existing->restore();
                }
            }
        }
        return response()->json(['message' => 'Usuario asignado correctamente']);
    }

    public function delete(Request $request){
        $request->validate([
            'items.*.id' => 'required|exists:project_requirement_assigneds,id',
        ]);

        foreach($request->items as $item){
            $project_requirement_assigned = ProjectRequirementAssigned::find($item['id']);
            $project_requirement_assigned->delete();
        }

        return response()->json(['message' => 'Asignacion removida correctamente']);
    }
}
