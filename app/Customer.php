<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function attendee()
    {
        return $this->hasOne('App\Evr_attendee', 'id', 'attendee_id');
    }
}
