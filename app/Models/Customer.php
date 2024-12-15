<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\User;
use App\Models\Commission;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sale_id',
        'Total_Sales',
        'refer_code',
        'refer_by',
        'position_parent',
        'position',
        'level',
        'Total_sale_commission',
        'matching_commission',
        'wallet_balance',
        'subscription_start_date',
        'subscription_end_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(Customer::class, 'refer_by', 'refer_code');
    }

    public function children()
    {
        return $this->hasMany(Customer::class, 'refer_by', 'refer_code');
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'user_id', 'user_id');
    }
    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'user_id');
    }

    public function walletTransactions()
{
    return $this->hasMany(Transaction::class, 'user_id');
}


}
