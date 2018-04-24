<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplyTo extends Model
{
    protected $table = 'apply_to';

    protected $fillable = [
        'name', 'created_by', 'groups_id', 'subject_id',
    ];

    public function group()
    {
        return $this->belongsTo('App\Group', 'groups_id');
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
