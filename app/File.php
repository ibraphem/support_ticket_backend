<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        "image_name",
        "ticketing_id"
    ];

    public function files()
    {
        return $this->belongsTo('App\Reply', 'ticketing_id', 'file_id');
    }
}
