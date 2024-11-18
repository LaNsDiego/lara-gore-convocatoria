<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $fillable = ['name','country_id'];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function provincies(){
        return $this->hasMany(Province::class);
    }
}
