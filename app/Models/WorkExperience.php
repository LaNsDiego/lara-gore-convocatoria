<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkExperience extends Model
{
    use SoftDeletes;
    public $fillable = [
        'id',
        'employee_id',
        'sector',
        'experience_type',
        'entity',
        'job_title',
        'functions_performed',
        'start_date',
        'end_date',
        'document_name',
        'file',
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public $appends = [
        'full_path_file',
    ];

    public function getFullPathFileAttribute()
    {
        return config('extravars.storage')."/".$this->attributes['file'];
    }
}
