<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //

    public $fillable = [
        "id",
        "document_type",
        "document_number",
        "first_name",
        "mother_last_name",
        "father_last_name",
        "sex",
        "marital_status",
        "date_of_birth",
        "phone_number",
        "email",
        "file_data_employee",
        "birth_city_id",
        "file_place_of_birth",
        "address_city_id",
        "file_address",
        "bank",
        "account_number",
        "cci",
        "account_type",
        "file_bank_account"
    ];


    public function address_city(){
        return $this->belongsTo(City::class);
    }

    public function birth_city(){
        return $this->belongsTo(City::class);
    }


    public $appends = [
        'full_path_file_bank_account',
        'full_path_file_data_employee',
        'full_path_file_address',
        'full_path_file_place_of_birth',
    ];
    protected function getFullPathFileBankAccountAttribute()
    {
        return config('extravars.storage')."/".$this->attributes['file_bank_account'];
    }
    protected function getFullPathFileDataEmployeeAttribute()
    {
        return config('extravars.storage')."/".$this->attributes['file_data_employee'];
    }
    protected function getFullPathFileAddressAttribute()
    {
        return config('extravars.storage')."/".$this->attributes['file_address'];
    }
    protected function getFullPathFilePlaceOfBirthAttribute()
    {
        return config('extravars.storage')."/".$this->attributes['file_place_of_birth'];
    }
      
}
