<?php

namespace App\Http\Controllers;

use App\Models\AuthorizationCertificate;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthorizationCertificateController extends Controller
{

    public function list_by_academic_training($academic_training_id){
        $authorization_certs = AuthorizationCertificate::where('academic_training_id',$academic_training_id)->get();
        return response()->json($authorization_certs);
    }
    public function store(Request $request){
        Log::info($request->all());
        $authorization_cert = new AuthorizationCertificate();
        $authorization_cert->academic_training_id = $request->academic_training_id;
        $authorization_cert->authorization_certificate = $request->authorization_certificate;
        $authorization_cert->authorization_start_date = $request->authorization_start_date;
        $authorization_cert->authorization_end_date = $request->authorization_end_date;
        $authorization_cert->authorization_file = '';
        if($request->hasFile('authorization_file') && $request->file('authorization_file')->getClientMimeType() !== 'image/*' ){
            $photo = $request->file('authorization_file');
            $authorization_cert->authorization_file = $photo->store('authorization_file','public');
        }
        $authorization_cert->save();

        return response()->json(['message' => 'Autorización creada correctamente']);
    }

    public function delete($id){
        $authorization_cert = AuthorizationCertificate::find($id);
        $authorization_cert->delete();
        return response()->json(['message' => 'Autorización eliminada correctamente']);
    }
}
