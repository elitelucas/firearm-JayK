<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evr_attendee extends Model
{
    protected $connection = 'mysql2';
    
    protected $table='evr_attendee';

    public function event()
    {
        return $this->hasOne('App\Evr_event', 'id', 'event_id');
    }
}
