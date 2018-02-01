<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $table = 'conversations';

    protected $fillable = [
        'name', 'table', 'id_record',
    ];

    public function itemsconversations() {
        return $this->hasMany('App\ItemConversation', 'conversation');
    }
}
