<?php

namespace App\Models;

use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Commission;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'customer_id', 'price', 'quantity', 'total_amount', 'status'];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function commission()
    {
        return $this->hasOne(Commission::class, 'product_id', 'product_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
