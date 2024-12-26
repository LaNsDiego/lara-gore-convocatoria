<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Person;
use App\Models\UserSir;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use stdClass;

class PersonController extends Controller
{
    public function find_on_sir(Request $request){

        $exists = Employee::where('document_number',$request->document_number)->exists();
        $person_sir = UserSir::
            where('pers_cod',$request->document_number)
            // ->orWhere('')
            ->first();

        $person = new stdClass();
        if($person_sir){

            $person->first_name = $person_sir->pers_nombre;
            $person->father_lastname = $person_sir->pers_apepat;
            $person->mother_lastname = $person_sir->pers_apemat;
            $person->sex = $person_sir->pers_sexo;
            return response()->json([
                'message' => 'Persona encontrada',
                'person' => $person,
                'exists' => $exists
            ]);
        }else{
            $result = self::consultarDNI($request->document_number);
            if( isset($result->success) && $result->success == true){
                $person->first_name = $result->data->nombres;
                $person->father_lastname = $result->data->apellido_paterno;
                $person->mother_lastname = $result->data->apellido_materno;
                $person->sex = '';

                return response()->json([
                    'message' => 'Persona encontrada en RENIEC',
                    'person' => $person,
                    'exists' => $exists
                ]);
            }else{
                return response()->json([
                    'message' => 'Persona no encontrada',
                    'person' => null
                ],Response::HTTP_NOT_FOUND);
            }
            
        }
    }

    public function consultarDNI($dni) {
        $token = '05781d2345540dc7d16a8b3ca6f55329ac205abe154b73f432a00e65da300a3a';
        // Iniciar llamada a API
        $curl = curl_init();
    
        // Configurar las opciones de cURL
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://apiperu.dev/api/dni',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 2,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode(['dni' => $dni]), // Enviar el DNI en el cuerpo
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json', // Especificar el tipo de contenido
                'Referer: https://apis.net.pe/consulta-dni-api',
                'Authorization: Bearer ' . $token
            ),
        ));
    
        // Ejecutar la solicitud
        $response = curl_exec($curl);
        Log::info($response);
        $error = curl_error($curl);
    
        curl_close($curl);
    
        // Manejar errores
        if ($error) {
            Log::error($error);
            return null;
        }
    
        // Decodificar y retornar la respuesta
        return json_decode($response);
    }
}
