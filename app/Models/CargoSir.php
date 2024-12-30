<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CargoSir extends Model
{
    protected $connection = 'pgsql_sir';
    protected $table = 'rrhh.cargo';
    // protected $keyType = 'string';
    protected $primaryKey = 'id_cargo';

    public $fillable = [
        'id_cargo',
        'nombre',
        'estado',
        'fch_reg',
        'cargo_codant',
        'eliminado',
        'sec_eje',
    ];

    public function profiles(){
        return $this->hasMany(Profile::class, 'job_title_id', 'id_cargo');
    }
}
