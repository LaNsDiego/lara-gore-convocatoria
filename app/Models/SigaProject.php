<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SigaProject extends Model
{
    protected $connection = 'sqlsrv';
    protected $table = 'tabla';

    protected $fillable = [
        'id',
        'name',
        'description',
        'created_at',
        'updated_at'
    ];

    
}
