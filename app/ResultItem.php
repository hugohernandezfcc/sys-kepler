<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ResultItem extends Model
{
    protected $table = 'results_items';

    protected $fillable = [
        'indication', 'result', 'answer', 'by',
    ];
    
    public function result()
    {
        return $this->belongsTo('App\Result', 'result');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'by');
    }
}
