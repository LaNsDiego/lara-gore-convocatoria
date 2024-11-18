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
        "city_id",
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
      
}
