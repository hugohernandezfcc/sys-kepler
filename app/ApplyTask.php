<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplyTask extends Model
{
    protected $table = 'apply_tasks';

    protected $fillable = [
        'name', 'by', 'task_id', 'group_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'by');
    }
}
