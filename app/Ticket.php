<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function agent()
    {
        return $this->belongsTo('App\User', 'agent_id', 'id');
    }
}
