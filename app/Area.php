<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    protected $table = 'areas';

    protected $fillable = [
        'name', 'created_by', 'description', 'school_cycle_id',
    ];

    public function schoolcycle()
    {
        return $this->belongsTo('App\SchoolCycle', 'school_cycle_id');
    }
    
    public function subjects()
    {
        return $this->hasMany('App\Subject', 'area_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
