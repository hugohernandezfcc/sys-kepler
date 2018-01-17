<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessTo extends Model
{
    protected $table = 'access_to';

    protected $fillable = [
        'name', 'created_by', 'user_id', 'group_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
