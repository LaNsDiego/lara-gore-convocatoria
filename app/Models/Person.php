<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $connection = 'pgsql_sir';

    public $table = "personal_demo";

    public $fillable = [
        'pers_cod',
        'pers_apepat',
        'pers_apemat',
        'pers_nombre',
        'pers_nombre_2',
        'pers_sexo',
        'pers_direccion',
        'pers_email',
        'pers_telef',
        'pers_fechnac',
        'pers_grusang',
        'pers_seguro',
        'estciv_id',
        'pers_sindic',
        'banco_id_1',
        'pers_banco_cta_1',
        'banco_id_2',
        'pers_banco_cta_2',
        'pers_cuspp',
        'pers_ctacts',
        'tp_doc_cod',
        'pers_sus4ta',
        'pers_sus4ta_num',
        'pers_sus4ta_fech',
        'pers_hijos',
        'pers_reloj',
        'pers_ruc',
        'sindicato_id',
        'dep_nac',
        'prov_nac',
        'dist_nac',
        'pers_codant',
        'dep_dir',
        'prov_dir',
        'dist_dir',
        'syslog',
        'nombr_fech',
        'nombr_documet',
        'pers_pens_susped',
        'ocupacion_cod',
        'nivel_cod',
        'pais_nac',
        'e4',
        'e5',
        'e17',

    ];
}
