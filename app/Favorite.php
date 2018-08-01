<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $table = 'favorites';

    protected $fillable = [
        'name', 'domain', 'link', 'type', 'by',
    ];

    public function user() {
        return $this->belongsTo('App\User', 'by');
    }
}
