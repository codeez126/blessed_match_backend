<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatMessage extends Model
{
    protected $fillable = [
        'chat_room_id',
        'sender_id',
        'receiver_id',
        'message',
        'type',
        'is_read',
    ];

    const TEXT = 1;
    const ATTACHMENT = 2;
    const PICTURE = 3;
    const VIDEO = 4;
    const VOICE = 5;

    public function sender()
    {
        return $this->belongsTo(User::class,'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class,'receiver_id');
    }

    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class,'chat_room_id');
    }

    public function media()
    {
        return $this->morphOne(Media::class, 'mediaable');
    }
}
