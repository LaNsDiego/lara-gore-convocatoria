<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PermissionSystem extends Model
{
    
    use SoftDeletes;
    

    protected $table = 'permission_systems';
    protected $fillable = [
        'id',
        'system_module_id',
        'action',
    ];

    public function system_module(){
        return $this->belongsTo(SystemModule::class,'system_module_id');
    }

}
