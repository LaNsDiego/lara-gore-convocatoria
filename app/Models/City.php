<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    //
    public $fillable = [
        "id",
        "name",
        "province_id"
    ];

    public function province(){
        return $this->belongsTo(Province::class,'province_id','id');
    }
    
}
