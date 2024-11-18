<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';
    protected $fillable = ['name','department_id'];

    public function department(){
        return $this->belongsTo(Department::class,'department_id','id');
    }

    public function cities(){
        return $this->hasMany(City::class);
    }
}
