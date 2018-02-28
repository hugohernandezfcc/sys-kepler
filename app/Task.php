<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'tasks';

    protected $fillable = [
        'name', 'created_by', 'subject_id',
    ];
    
    public function groups() {
        return $this->belongsToMany('App\Group', 'apply_tasks', 'task_id', 'group_id')->withPivot('name', 'by')->withTimestamps();
    }

    public function area()
    {
        return $this->belongsTo('App\Area', 'area_id');
    }
    
    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
