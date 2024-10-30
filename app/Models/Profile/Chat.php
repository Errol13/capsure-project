<?php

namespace App\Models\Profile;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'conversation_id',
        'sender',
        'recipient',
        'message',
        'isRead',
    ];

    public function senderUser()
    {
        // Defines the relationship for the sender
        return $this->belongsTo(User::class, 'sender');
    }

    public function recipientUser()
    {
        // Defines the relationship for the recipient
        return $this->belongsTo(User::class, 'recipient');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }
}
