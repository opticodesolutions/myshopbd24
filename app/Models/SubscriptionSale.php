<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionSale extends Model
{
    use HasFactory;
    protected $fillable = [
        'subscription_id',
        'user_id',
        'customer_id',
        'total_amount',
        'status',
    ];

    // Relationship with Subscription
    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // Relationship with Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
