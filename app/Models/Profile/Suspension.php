<?php

namespace App\Models\Profile;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suspension extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'isSuspended',
        'total_successful_hiring',
        'start_date',
        'end_date',
    ];

    protected $primaryKey = 'suspension_id';

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

}
