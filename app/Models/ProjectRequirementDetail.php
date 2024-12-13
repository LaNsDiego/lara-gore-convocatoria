<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectRequirementDetail extends Model
{
    public $fillable = [
        'id',
        'primary',
        'project_requirement_id',
        'dni',
        'first_name',
        'father_last_name',
        'mother_last_name',
        'amount_required',
        'amount_rrhh',
        'observation',
        'job_title_id',
        'job_profiles_selected',
        'deleted_at',
        'created_at',
        'updated_at',
    ];
}
