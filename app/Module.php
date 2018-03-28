<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';

    protected $fillable = [
        'name', 'created_by', 'subject_id',
    ];

    public function subject()
    {
        return $this->belongsTo('App\Subject', 'subject_id');
    }
    
    public function links()
    {
        return $this->hasMany('App\Link', 'module_id', 'id');
    }
    
    public function articles()
    {
        return $this->hasMany('App\Article', 'module_id', 'id');
    }
    
    public function forums()
    {
        return $this->hasMany('App\Forum', 'module_id', 'id');
    }
    
    public function walls()
    {
        return $this->hasMany('App\Wall', 'module_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by');
    }
}
