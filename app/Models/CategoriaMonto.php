<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriaMonto extends Model
{
    
    protected $connection = 'pgsql_sir';
    protected $table = 'rrhh.categoria_monto';
    protected $primaryKey = 'categoria_monto_id';

    public $fillable = [
        'categoria_monto_id',
        'categoria_cod',
        'conlab_cod',
        'rubro_cod',
        'cat_monto_valor',
        'estado',
        'descripcion',
        'fech_ini',
        'fech_fin',
    ];
}
