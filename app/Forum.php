<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Forum extends Model
{
    protected $table = 'forums';

    protected $fillable = [
        'name', 'created_by', 'description', 'module_id',
    ];

    public function questionsforums() {
        return $this->hasMany('App\QuestionForum', 'forum_id', 'id');
    }

    public function module() {
        return $this->belongsTo('App\Module', 'module_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
