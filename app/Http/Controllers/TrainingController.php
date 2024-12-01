<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{

    public function list($employee_id){
        $trainings = Training::where('employee_id',$employee_id)->get();
        return response()->json($trainings);
    }

    public function store(Request $request){
        $request->validate([
            'employee_id' => ['required', 'integer', 'min:1'],
            'study_type' => ['required', 'string', 'max:255'],
            'topic' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'participation_type' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'country_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'date_expedition' => ['required', 'date'],
            'qualification_entity_control' => ['required', 'string', 'max:255'],
            'issue_date' => ['required', 'date'],
            'registry_number' => ['required', 'string', 'max:255'],
            'registry_center' => ['required', 'string', 'max:255'],
            'date_resolution' => ['required', 'date'],
            'number_resolution' => ['required', 'string', 'max:255'],
            // 'file' => ['nullable', 'file', 'mimes:pdf,jpg,png'], // Archivo opcional con restricciones
        ]);

        $new = new Training();
        $new->employee_id = $request->employee_id;
        $new->study_type = $request->study_type;
        $new->topic = $request->topic;
        $new->start_date = $request->start_date;
        $new->end_date = $request->end_date;
        $new->participation_type = $request->participation_type;
        $new->institution = $request->institution;
        $new->country_id = $request->country_id;
        $new->city_id = $request->city_id;
        $new->hours = $request->hours;
        $new->credits = $request->credits;
        $new->city_id = $request->city_id;
        $new->date_expedition = $request->date_expedition;
        $new->qualification_entity_control = $request->qualification_entity_control;
        $new->issue_date = $request->issue_date;
        $new->registry_number = $request->registry_number;
        $new->registry_center = $request->registry_center;
        $new->date_resolution = $request->date_resolution;
        $new->number_resolution = $request->number_resolution;
        $new->file = '';
        $new->file_register = '';

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('trainings', 'public');
            $new->file = $filePath; // Asegúrate de tener una columna para almacenar esta ruta en tu base de datos
        }
        if ($request->hasFile('file_register')) {
            $file_register = $request->file('file_register')->store('trainings', 'public');
            $new->file_register = $file_register; // Asegúrate de tener una columna para almacenar esta ruta en tu base de datos
        }
        $new->save();

        return response()->json(['message' => 'Training created successfully',], 201);
    }
}
