<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function files()
    {
        return $this->hasMany('App\File', 'ticketing_id', 'file_id');
    }
}
