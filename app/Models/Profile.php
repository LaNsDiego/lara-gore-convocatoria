<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Profile extends Model
{
    use SoftDeletes;
    

    protected $fillable = [
        'id',
        'job_title_id',
        'request_name',
        'description',
        'status',
    ];

    public function job_title()
    {
        return $this->belongsTo(JobTitle::class);
    }

}