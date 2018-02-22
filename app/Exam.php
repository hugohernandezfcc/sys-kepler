<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';

    protected $fillable = [
        'name', 'created_by', 'subject_id', 'area_id', 'description',
    ];
    
    public function groups() {
        return $this->belongsToMany('App\Group', 'apply_exams', 'exam_id', 'group_id')->withPivot('name', 'by')->withTimestamps();
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
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
