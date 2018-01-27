<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemConversation extends Model
{
    protected $table = 'items_conversations';

    protected $fillable = [
        'name', 'by', 'type', 'parent', 'conversation',
    ];

    public function children() {
        return $this->hasMany( 'App\ItemConversation', 'parent', 'id' );
    }

    public function parent() {
        return $this->hasOne( 'App\ItemConversation', 'id', 'parent' );
    }
    
    public function conversation() {
        return $this->belongsTo('App\Conversation', 'conversation');
    }
    
    public function user() {
        return $this->belongsTo('App\User', 'by');
    }

}
