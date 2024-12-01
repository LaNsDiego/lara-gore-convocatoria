<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class UserSir extends Model
{
    protected $connection = 'pgsql_sir';
    protected $table = 'sys.usuario';
    protected $primaryKey = 'usuario_cod';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'usuario_cod',
        'usuario_pass',
        'usuario_nomb',
        'usuario_apat',
        'usuario_amat',
        'usuario_dni',
        'usuario_estado',
        'usuario_fechreg',
        'usuario_fechexp',
        'sys_log',
        'sec_eje',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'usuario_pass',
    ];
}
