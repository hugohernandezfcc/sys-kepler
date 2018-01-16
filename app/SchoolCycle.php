<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolCycle extends Model
{
    protected $table = 'school_cycles';

    public function areas()
    {
        return $this->hasMany('App\Area');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
