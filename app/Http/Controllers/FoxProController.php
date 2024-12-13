<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FoxProController extends Controller
{
    public function find_by_expendspecific_secfunc(Request $request){
                
        $functional_sequence_formatted = str_pad($request->functional_sequence, 4, '0', STR_PAD_LEFT);
        // $request->specific_expenditure
                //no cambiar el orden de los parametros
                $params = [
                    'sec_func' => $functional_sequence_formatted,
                    'ano_eje' => '2024',
                    'sec_ejec' =>'000931'
                ];
                $filename = 'C:\Users\dvans\Documents\developing\consumervfp\input.txt';

                self::escribirEnTxt($filename, $params);

                $comando = "C:\Users\dvans\Documents\developing\consumervfp\consumer_siaf.exe";
                try {
                    $output = shell_exec($comando);
                } catch (\Throwable $th) {
                    return response()->json([
                        'message' => 'Error al ejecutar el comando'
                    ],500);
                }

                return response()->json($request->all());
    }

    private function escribirEnTxt($rutaArchivo, $parametros) {
        // Asegúrate de que $parametros sea un array
        if (!is_array($parametros)) {
            return "Error: Los parámetros deben ser un array.";
        }
        
        // Abrir el archivo en modo de escritura ('w' borra el contenido existente)
        $archivo = fopen($rutaArchivo, 'w'); // Cambiado de 'a' a 'w'
        if (!$archivo) {
            return "Error: No se pudo abrir el archivo.";
        }
        
        // Convertir el array a una línea separada por comas
        $linea = implode(",", $parametros) . PHP_EOL; // Añadir un salto de línea
        
        // Escribir la línea en el archivo
        if (fwrite($archivo, $linea) === false) {
            fclose($archivo); // Asegúrate de cerrar el archivo aunque falle
            return "Error: No se pudo escribir en el archivo.";
        }
        
        // Cerrar el archivo
        fclose($archivo);
        return "Los datos se han escrito correctamente en el archivo.";
    }
    
}
