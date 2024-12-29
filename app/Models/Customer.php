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


    public function getGenerationsTree($generation = 1, $maxGenerations = 12)
    {
        $result = [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'refer_code' => $this->refer_code,
            'refer_by' => $this->refer_by,
            'wallet_balance' => $this->wallet_balance,
            'generation' => $generation,
            'position_parent' => $this->position_parent,
            'position' => $this->position,
            'profile_image' => $this->user->profile_picture,
            'children' => [],
        ];

        if ($generation < $maxGenerations) {
            $children = self::where('refer_by', $this->refer_code)->get();

            foreach ($children as $child) {
                $result['children'][] = $child->getGenerationsTree($generation + 1, $maxGenerations);
            }
        }

        return $result;
    }

    public function getGenerations($generation = 1, $maxGenerations = 15)
    {
        $result = [];

        if ($generation <= $maxGenerations) {
            $children = self::where('refer_by', $this->refer_code)->get();

            foreach ($children as $child) {
                $result[$generation][] = $child->user_id;

                // Recursive call to get the next generation
                $childGenerations = $child->getGenerations($generation + 1, $maxGenerations);
                foreach ($childGenerations as $gen => $ids) {
                    $result[$gen] = array_merge($result[$gen] ?? [], $ids);
                }
            }
        }

        return $result;
    }
}
