<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $table = 'votes';

    protected $fillable = [
        'name', 'by', 'type', 'question_forum'
    ];
    
    public function questionforum() {
        return $this->belongsTo('App\QuestionForum', 'question_forum');
    }
    
    public function user() {
        return $this->belongsTo('App\User', 'by');
    }
}
