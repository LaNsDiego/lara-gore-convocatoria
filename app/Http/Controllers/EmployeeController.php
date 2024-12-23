<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmployeeController extends Controller
{
    public function list(){
        $token = JWTAuth::fromUser(Auth::user());
        $payload = JWTAuth::setToken($token)->getPayload();
        
        $employees = Employee::where('executor_unit',$payload['executor_unit'])->with(['address_city.province.department.country','birth_city.province.department.country'])->get();
        return response()->json($employees);
    }

    public function get_one($employee_id){
        $employee = Employee::find($employee_id);
        return response()->json($employee);
    }

    public function store(Request $request){

        $request->validate([
            'document_type' => 'required|string|max:255',
            'document_number' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'mother_last_name' => 'required|string|max:255',
            'father_last_name' => 'required|string|max:255',
            'sex' => 'required|string',
            'marital_status' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'birth_city_id' => 'required|integer',
            'address_city_id' => 'required|integer',
            'address' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'cci' => 'required|string|max:255',
            'account_type' => 'required|string|max:255',
            'executor_unit' => 'required',
        ]);
        
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
        $employee->executor_unit = $request->executor_unit;

        $employee->file_data_employee = '';
        if($request->hasFile('file_data_employee')){
            $photo = $request->file('file_data_employee');
            $employee->file_data_employee = $photo->store('data_employee','public');
        }

        $employee->birth_city_id = $request->birth_city_id;
        
        $employee->file_place_of_birth = '';
        if($request->hasFile('file_place_of_birth')){
            $photo = $request->file('file_place_of_birth');
            $employee->file_place_of_birth = $photo->store('place_of_birth','public');
            
        }

        $employee->address_city_id = $request->address_city_id;
        $employee->address = $request->address;
        $employee->file_address = '';
        if($request->hasFile('file_address')){
            $photo = $request->file('file_address');
            $employee->file_address = $photo->store('address','public');
        }

        $employee->bank = $request->bank;
        $employee->account_number = $request->account_number;
        $employee->cci = $request->cci;
        $employee->account_type = $request->account_type;
        $employee->file_bank_account = $request->file_bank_account;
        $employee->file_bank_account = '';
        if($request->hasFile('file_bank_account')){
            $photo = $request->file('file_bank_account');
            $employee->file_bank_account = $photo->store('bank_account','public');
        }
        $employee->save();
        return response()->json(['message' => 'Datos personales ingresados correctamente'],Response::HTTP_CREATED);
    }

    public function update(Request $request){

        // Log::info($request->all());
        $request->validate([
            'id' => 'required|exists:employees,id',
            'sex' => 'required|string',
            'marital_status' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'phone_number' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'birth_city_id' => 'required|integer',
            'address_city_id' => 'required|integer',
            'address' => 'required|string|max:255',
            'bank' => 'required|string|max:255',
            'account_number' => 'required|string|max:255',
            'cci' => 'required|string|max:255',
            'account_type' => 'required|string|max:255',
        ]);

        $employee = Employee::find($request->id);
        $employee->sex = $request->sex;
        $employee->marital_status = $request->marital_status;
        $employee->date_of_birth = $request->date_of_birth;
        $employee->phone_number = $request->phone_number;
        $employee->email = $request->email;

        
        if($request->hasFile('file_data_employee') && $request->file('file_data_employee')->getClientMimeType() !== 'image/*'){
            $photo = $request->file('file_data_employee');
            $employee->file_data_employee = $photo->store('data_employee','public');
        }

        $employee->birth_city_id = $request->birth_city_id;
        
        
        if($request->hasFile('file_place_of_birth') && $request->file('file_place_of_birth')->getClientMimeType() !== 'image/*'){
            $photo = $request->file('file_place_of_birth');
            $employee->file_place_of_birth = $photo->store('place_of_birth','public');
            
        }

        $employee->address_city_id = $request->address_city_id;
        $employee->address = $request->address;
        
        if($request->hasFile('file_address') && $request->file('file_address')->getClientMimeType() !== 'image/*'){
            $photo = $request->file('file_address');
            $employee->file_address = $photo->store('address','public');
        }

        $employee->bank = $request->bank;
        $employee->account_number = $request->account_number;
        $employee->cci = $request->cci;
        $employee->account_type = $request->account_type;
        $employee->file_bank_account = $request->file_bank_account;
        
        if($request->hasFile('file_bank_account') && $request->file('file_bank_account')->getClientMimeType() !== 'image/*' ){
            $photo = $request->file('file_bank_account');
            $employee->file_bank_account = $photo->store('bank_account','public');
        }
        $employee->save();
        return response()->json(['message' => 'Datos personales ingresados correctamente'],Response::HTTP_CREATED);
    }

    public function delete(Request $request,$id){

        $employee = Employee::find($id);
        $employee->delete();
        return response()->json(['message' => 'Datos personales eliminados correctamente'],Response::HTTP_OK);
    }
}
