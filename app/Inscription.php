<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $table = 'inscriptions';

    protected $fillable = [
        'name', 'description', 'columns_name', 'type_user', 'created_by',
    ];
    
    public function user() {
        return $this->belongsTo('App\User', 'created_by');
    }
}
