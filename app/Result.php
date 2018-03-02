<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $table = 'results';

    protected $fillable = [
        'type', 'id_record', 'name_record', 'by', 'group_id',
    ];
    
    public function task()
    {
        return $this->belongsTo('App\Task', 'id_record');
    }
    
    public function exam()
    {
        return $this->belongsTo('App\Exam', 'id_record');
    }
    
    public function group()
    {
        return $this->belongsTo('App\Group', 'group_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'by');
    }
}
