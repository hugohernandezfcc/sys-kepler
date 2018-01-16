<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolCycle extends Model
{
    protected $table = 'school_cycles';

    protected $fillable = [
        'name', 'created_by',
    ];

    public function areas()
    {
        return $this->hasMany('App\Area');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
