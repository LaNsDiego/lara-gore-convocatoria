<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectRequirementAssigned extends Model
{
    use SoftDeletes;
    //

    public function user(){
        return $this->belongsTo(User::class);
    }
}
