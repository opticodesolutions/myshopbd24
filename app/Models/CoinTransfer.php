<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoinTransfer extends Model
{
    use HasFactory;
    protected $table = 'coin_transfer';

    protected $fillable = [
        'sender_user_id',
        'receiver_user_id',
        'amount',
        'trx_id',
        'status',
    ];

    // Relationships with the User model
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_user_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_user_id');
    }
}
