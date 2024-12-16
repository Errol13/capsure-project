<?php

namespace App\Models;

use App\Models\Profile\Chat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'recipient_id',
        'last_time_message',
    ];

    protected $primaryKey = 'conversation_id';

    public function messages()
    {
        return $this->hasMany(Chat::class,'conversation_id'); 
    }

    // Relationship to retrieve the sender
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Relationship to retrieve the recipient
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }
}
