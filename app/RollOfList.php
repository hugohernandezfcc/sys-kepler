<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RollOfList extends Model
{
    protected $table = 'roll_of_lists';

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
