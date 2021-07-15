<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evr_event extends Model
{
    protected $connection = 'mysql2';
    
    protected $table='evr_event';
}
