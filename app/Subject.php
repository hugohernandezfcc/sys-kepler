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
        return $this->belongsToMany('App\Group', 'apply_to', 'subject_id', 'groups_id')->withPivot('name', 'created_by')->withTimestamps();
    }

    public function tasks()
    {
        return $this->hasMany('App\Task', 'subject_id', 'id');
    }

    public function exams()
    {
        return $this->hasMany('App\Exam', 'subject_id', 'id');
    }

    public function modules()
    {
        return $this->hasMany('App\Module', 'subject_id', 'id');
    }

    public function rolloflists()
    {
        return $this->hasMany('App\RollOfList', 'subject_id', 'id');
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
