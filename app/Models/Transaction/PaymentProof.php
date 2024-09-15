<?php

namespace App\Models\Transaction;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentProof extends Model
{
    use HasFactory;

    protected $table = 'payment_proofs';

    // Define the fillable attributes
    protected $fillable = [
        'transaction_id',
        'file_path',
        'payment_type',
    ];

    protected $primaryKey = 'proof_id';

    public function transaction(){
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

}
