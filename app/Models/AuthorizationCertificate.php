<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthorizationCertificate extends Model
{
    

    protected $fillable = [
        'academic_training_id',
        'authorization_certificate',
        'authorization_start_date',
        'authorization_end_date',
        'authorization_file',
    ];

    public $appends = [
        'full_path_authorization_file',
    
    ];

    public function getFullPathAuthorizationFileAttribute()
    {
        return config('extravars.storage')."/".$this->attributes['authorization_file'];
    }
}
