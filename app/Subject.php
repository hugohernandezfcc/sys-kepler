<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $table = 'subjects';

    protected $fillable = [
        'name', 'created_by', 'area_id',
    ];

    public function groups() {
        return $this->belongsToMany('App\Group', 'apply_to', 'subject_id', 'group_id');
    }

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
        return $this->belongsTo('App\Area', 'area_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
