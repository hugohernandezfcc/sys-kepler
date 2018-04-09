<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wall extends Model
{
    protected $table = 'walls';

    protected $fillable = [
        'name', 'created_by', 'description', 'module_id',
    ];

    public function posts() {
        return $this->hasMany('App\Post', 'wall_id', 'id');
    }

    public function module() {
        return $this->belongsTo('App\Module', 'module_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
