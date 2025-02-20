<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    public $fillable = [

    'is_civil',
    'project_requirement_detail_id',
    'dias_laborados',
    'cantidad_domingos',
    'cantidad_feriados',
    'hijos',
    'jornal_diario',
    'remuneracion_basica',
    'buc',
    'vacaciones_truncas',
    'cts',
    'movilidad',
    'escolaridad',
    'jornal_dominical',
    'gratificacion',
    'bonificacion_l29714',
    'pago_feriado',
    'total_remuneracion',
    'remuneracion_asegur',
    'essalud',
    'essalud_vida',
    'sctr',
    'crecer_seg',
    'total_aportes',
    'total',
    ];
}
