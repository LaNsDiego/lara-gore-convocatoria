<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class JobTitle extends Model
{
    use SoftDeletes;
    

    protected $fillable = [
        'id',
        'code',
        'name',
        'status',
        'observation',
        'executor_unit',
    ];

    public function profiles()
    {
        return $this->hasMany(Profile::class);
    }

}