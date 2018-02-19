<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemsExam extends Model
{
    protected $table = 'items_exam';

    protected $fillable = [
        'name', 'by', 'type', 'parent', 'exam', 'subtype',
    ];

    public function children() {
        return $this->hasMany('App\ItemsExam', 'parent', 'id');
    }

    public function parent() {
        return $this->belongsTo('App\ItemsExam', 'id', 'parent');
    }
    
    public function conversation() {
        return $this->belongsTo('App\Exam', 'exam');
    }
    
    public function user() {
        return $this->belongsTo('App\User', 'by');
    }
}
