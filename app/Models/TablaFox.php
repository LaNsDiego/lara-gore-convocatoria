<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TablaFox extends Model
{

    protected $connection = 'foxpro';

    public $table = "gasto";


}
