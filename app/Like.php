<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $table = 'likes';

    protected $fillable = [
        'name', 'body', 'created_by', 'post_id',
    ];

    public function post() {
        return $this->belongsTo('App\Post', 'post_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
