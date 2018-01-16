<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }

    public function exams()
    {
        return $this->hasMany('App\Exam');
    }

    public function modules()
    {
        return $this->hasMany('App\Module');
    }

    public function rolloflists()
    {
        return $this->hasMany('App\RollOfList');
    }

    public function area()
    {
        return $this->belongsTo('App\Area');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
