<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplyExam extends Model
{
    protected $table = 'apply_exams';

    protected $fillable = [
        'name', 'by', 'exam_id', 'group_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'by');
    }
}
