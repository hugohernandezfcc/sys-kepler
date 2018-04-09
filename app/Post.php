<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $table = 'posts';

    protected $fillable = [
        'name', 'body', 'created_by', 'wall_id',
    ];

    public function likes() {
        return $this->hasMany('App\Like', 'post_id', 'id');
    }

    public function wall() {
        return $this->belongsTo('App\Wall', 'wall_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
