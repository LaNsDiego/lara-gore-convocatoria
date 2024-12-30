<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Profile extends Model
{
    public $table = 'profiles';
    use SoftDeletes;
    

    protected $fillable = [
        'id',
        'job_title_id',
        'request_name',
        'description',
        'status',
        'executor_unit',
    ];

    public function job_title()
    {
        // return $this->belongsTo(JobTitle::class);
        return $this->belongsTo(CargoSir::class,'job_title_id','id_cargo');
    }

}