<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExecutingUnit extends Model
{
    protected $connection = 'pgsql_sir';
    protected $table = 'sys.unidad_ejecutora';
    protected $primaryKey = 'sec_eje';
    protected $fillable = [
        'sec_eje',
        'nombre',
        'ruc',
        'estado',
    ];
    
}
