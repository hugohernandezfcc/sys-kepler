<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    protected $table = 'columns';

    protected $fillable = [
        'name', 'type', 'label', 'required', 'created_by',
    ];
    
    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
