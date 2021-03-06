<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $table = 'links';

    protected $fillable = [
        'name', 'created_by', 'description', 'module_id',
    ];

    public function module() {
        return $this->belongsTo('App\Module', 'module_id');
    }

    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
