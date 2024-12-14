<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notes',
        'created_by_sms',
        'created_by_user_id',
        'created_by',
        'payment_method',
        'account_id',
        'transaction_id',
        'amount',
        'type',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
