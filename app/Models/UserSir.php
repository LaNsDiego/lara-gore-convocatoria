<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserSir extends Model
{
    protected $connection = 'pgsql_sir';
    protected $table = 'rrhh.personal';
    protected $keyType = 'string';
    // protected $primaryKey = 'usuario_cod';
    protected $primaryKey = 'pers_cod';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pers_cod',
        'pers_apepat',
        'pers_apemat',
        'pers_nombre',
        'pers_nombre_2',
        'pers_sexo',
        'pers_direccion',
        'sec_eje',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'usuario_pass',
    ];
}
