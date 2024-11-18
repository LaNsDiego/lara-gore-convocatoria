<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmployeeController extends Controller
{
    public function list(){
        $employees = Employee::with(['address_city.province.department.country','birth_city.province.department.country'])->get();
        return response()->json($employees);
    }

    public function store(Request $request){
        $employee = new Employee();
        
        $employee->document_type = $request->document_type;
        $employee->document_number = $request->document_number;
        $employee->first_name = $request->name;
        $employee->mother_last_name = $request->mother_last_name;
        $employee->father_last_name = $request->father_last_name;
        $employee->sex = $request->sex;
        $employee->marital_status = $request->marital_status;
        $employee->date_of_birth = $request->date_of_birth;
        $employee->phone_number = $request->phone_number;
        $employee->email = $request->email;

        $employee->file_data_employee = '';
        if($request->hasFile('file_data_employee')){
            $photo = $request->file('file_data_employee');
            $employee->file_data_employee = $photo->store('data_employee','public');
        }

        $employee->birth_city_id = $request->birth_city_id;
        
        $employee->file_place_of_birth = '';
        if($request->hasFile('file_place_of_birth')){
            foreach($request->file('file_place_of_birth') as $photo){
                $employee->file_place_of_birth = $photo->store('place_of_birth','public');
            }
        }

        $employee->address_city_id = $request->address_city_id;
        $employee->address = $request->address;
        $employee->file_address = '';
        if($request->hasFile('file_address')){
            foreach($request->file('file_address') as $photo){
                $employee->file_address = $photo->store('address','public');
            }
        }

        $employee->bank = $request->bank;
        $employee->account_number = $request->account_number;
        $employee->cci = $request->cci;
        $employee->account_type = $request->account_type;
        $employee->file_bank_account = $request->file_bank_account;
        $employee->file_bank_account = '';
        if($request->hasFile('file_bank_account')){
            foreach($request->file('file_bank_account') as $photo){
                $employee->file_bank_account = $photo->store('bank_account','public');
            }
        }
        $employee->save();
        return response()->json(['message' => 'Datos personales ingresados correctamente'],Response::HTTP_CREATED);
    }
}
