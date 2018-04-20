<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionForum extends Model
{
    protected $table = 'questions_forums';

    protected $fillable = [
        'name', 'body', 'created_by', 'forum_id',
    ];

    public function votes() {
        return $this->hasMany('App\Vote', 'question_forum', 'id');
    }

    public function itemconversation() {
        return $this->belongsTo('App\ItemConversation', 'id', 'name');
    }

    public function forum() {
        return $this->belongsTo('App\Forum', 'forum_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
