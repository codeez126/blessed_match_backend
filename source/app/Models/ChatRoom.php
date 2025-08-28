<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ChatRoom extends Model
{
    protected $fillable = [
        'name',
        'auth_user_id',
        'receiver_id',
        'status',
    ];

    public function chatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_room_id')->with(['sender', 'receiver']);
    }

    public function users()
    {
        return $this->belongsToMany(RoomUser::class, 'room_users');
    }

    public function unreadChatMessages()
    {
        return $this->hasMany(ChatMessage::class, 'chat_room_id')->where('is_read', 0);
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'chat_room_id')->latest()->limit(1)->with(['sender', 'receiver']);
    }
    public function lastMessageForApi()
    {
        return $this->hasOne(ChatMessage::class, 'chat_room_id')
            ->ofMany('created_at', 'max')
            ->with(['sender', 'receiver']);
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'auth_user_id');
    }
    public function senderWithProfile()
    {
        return $this->belongsTo(User::class, 'auth_user_id')
            ->with(['mmProfile', 'clientAbout']);
    }

    public function receiverWithProfile()
    {
        return $this->belongsTo(User::class, 'receiver_id')
            ->with(['mmProfile', 'clientAbout']);
    }


}
