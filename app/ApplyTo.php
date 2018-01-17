<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplyTo extends Model
{
    protected $table = 'apply_to';

    protected $fillable = [
        'name', 'created_by', 'user_id', 'subject_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
