<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_type',
        'id_card_image',
        'pic_with_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
