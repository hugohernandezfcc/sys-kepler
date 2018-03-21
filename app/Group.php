<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name', 'created_by', 'description',
    ];

    public function subjects() {
    	return $this->belongsToMany('App\Subject', 'apply_to', 'groups_id', 'subject_id')->withPivot('name', 'created_by')->withTimestamps();
    }

    public function users() {
    	return $this->belongsToMany('App\User', 'access_to', 'group_id', 'user_id')->withPivot('name', 'created_by')->withTimestamps();
    }
    
    public function exams() {
    	return $this->belongsToMany('App\Exam', 'apply_exams', 'group_id', 'exam_id')->withPivot('name', 'by')->withTimestamps();
    }

    public function tasks() {
    	return $this->belongsToMany('App\Task', 'apply_tasks', 'group_id', 'task_id')->withPivot('name', 'by')->withTimestamps();
    }

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
