<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectRequirement extends Model
{
    use SoftDeletes;

    public function assignations(){
        return $this->hasMany(ProjectRequirementAssigned::class,'project_requeriment_id','id');
    }
}
