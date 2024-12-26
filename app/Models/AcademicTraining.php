<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicTraining extends Model
{
    
    // relations
    public function employee(){
        return $this->belongsTo(Employee::class);
    }

    public function educationCountry(){
        return $this->belongsTo(Country::class, 'education_country_id');
    }

    public function academic_situation_city(){
        return $this->belongsTo(City::class, 'academic_situation_city_id');
    }

    // attributes
    protected $fillable = [
        'employee_id',
        'educational_level',
        'education_country_id',
        'education_study_center',
        'academic_situation',
        'academic_situation_start_year',
        'academic_situation_end_year',
        'academic_situation_city_id',
        'academic_degree',
        'academic_degree_level',
        'academic_degree_specialty',
        'qualification_title',
        'qualification_specialty',
        'qualification_expedition_date',
        'qualification_entity_control',
        'qualification_registration_center',
        'qualification_registration_number',
        'qualification_registration_date',
        'qualification_resolution_date',
        'qualification_resolution_number',
        'qualification_file',
        'tuition_school',
        'tuition_number',
        'tuition_date',
        'tuition_file',
    ];

    public function authorization_certificates(){
        return $this->hasMany(AuthorizationCertificate::class);
    }


    public $appends = [
        'full_path_qualification_file',
        'full_path_tuition_file',
    ];

    public function getFullPathQualificationFileAttribute()
    {
        return config('extravars.storage')."/".$this->attributes['qualification_file'];
    }
    
    public function getFullPathTuitionFileAttribute()
    {
        return config('extravars.storage')."/".$this->attributes['tuition_file'];
    }

}
