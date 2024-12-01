<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Role extends Model
{
    
    use SoftDeletes;
    

    protected $fillable = [
        'id',
        'name',
    ];

    public function permissions(){
        return $this->hasMany(RoleHasPermission::class,'role_id')->orderBy('permission_id','asc');
    }
    
}
