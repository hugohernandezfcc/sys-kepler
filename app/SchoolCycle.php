<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SchoolCycle extends Model
{
    protected $table = 'school_cycles';

    protected $fillable = [
        'name', 'start', 'end', 'description', 'created_by',
    ];

    public function areas()
    {$table->softDeletes();
        return $this->hasMany('App\Area');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
