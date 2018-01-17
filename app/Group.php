<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'groups';

    protected $fillable = [
        'name', 'created_by',
    ];

    public function subjects() {
    	return $this->belongsToMany('App\Subject', 'apply_to', 'group_id', 'subject_id');
    }

    public function users() {
    	return $this->belongsToMany('App\User', 'access_to', 'group_id', 'user_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
