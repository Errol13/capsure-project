<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender',
        'recepient',
        'message',
        'isRead',
    ];

    public function senderUser()
    {
        return $this->belongsTo(User::class, 'sender');
    }

    public function recipientUser()
    {
        return $this->belongsTo(User::class, 'recipient');
    }
}
