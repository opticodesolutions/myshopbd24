<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubcriptioRenew extends Model
{
    use HasFactory;
    protected $table = 'subcriptio_renews';
    protected $fillable = [
        'user_id',
        'renewal_date',
        'payment_status',
        'renewal_amount',
        'remarks',
        'payment_method'
    ];
    public function user()
    {
        return $this->belongsTo(User::class); 
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id', 'user_id');
    }
}
