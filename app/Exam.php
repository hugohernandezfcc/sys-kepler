<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $table = 'exams';

    protected $fillable = [
        'name', 'created_by', 'subject_id',
    ];

    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
