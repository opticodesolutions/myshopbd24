<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'Total_Sales',
        'refer_code',
        'refer_by',
        'Total_sale_commission',
        'wallet_balance'
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

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'user_id');
    }

    // public function withdrawals()
    // {
    //     return $this->hasMany(Withdrawal::class, 'user_id', 'user_id');
    // }

    public function calculateCommissions($product)
    {
        $salesAmount = $product->discount_price;
        $procom = Commission::where('product_id', $product->id)->first();

        $commissionRate = $procom ->amount;
        $totalCommission = $salesAmount * $commissionRate;

        $commissionDistribution = [
            [1.00],                    // Level 3 sells
            [0.60, 0.40],             // Level 2 sells
            [0.50, 0.30, 0.20],       // Level 1 sells
            [0.40, 0.25, 0.20, 0.15] // Level 0 sells
        ];

        // Determine the user's level
        $current_user = $this;
        $level = 0;
        while ($current_user->parent && $level < 3) {
            $current_user = $current_user->parent;
            $level++;
        }

        // Apply the appropriate commission distribution based on the user's level
        $current_user = $this;
        $commissionsDistributed = [];
        foreach ($commissionDistribution[$level] as $index => $percentage) {
            $commission = $totalCommission * $percentage;
            $current_user->Total_sale_commission += $commission;
            $current_user->wallet_balance += $commission;
            $current_user->save();

            // echo "User {$current_user->user->name} (level {$level}) receives {$commission} commission.\n";

            $commissionsDistributed[$index] = [
                'user_id' => $current_user->user_id,
                'commission' => $commission
            ];

            $current_user = $current_user->parent;
            if (!$current_user) {
                break;
            }
        }

        return $commissionsDistributed;
    }

    // public function calculateCommissions($product)
    // {
    //     // Assume $product->discount_price is the sales amount
    //     $salesAmount = $product->discount_price;

    //     // Calculate the total commission based on the product's discount price
    //     $totalCommission = $salesAmount * ($product->commissions->sum('amount') ?: 0.00);

    //     // Commission distribution percentages by level
    //     $commissionDistribution = [
    //         [0.40, 0.25, 0.20, 0.15], // Level 0 (current user)
    //         [0.50, 0.30, 0.20],       // Level 1
    //         [0.60, 0.40],             // Level 2
    //         [1.00]                    // Level 3
    //     ];

    //     // Determine the user's level and collect users
    //     $current_user = $this;
    //     $level = 0;
    //     $users = [];

    //     // Collect users up the hierarchy
    //     while ($current_user && $level < count($commissionDistribution)) {
    //         $users[$level] = $current_user;
    //         $current_user = $current_user->parent;
    //         $level++;
    //     }

    //     // Distribute commissions based on collected users and their levels
    //     $remainingCommission = $totalCommission;

    //     foreach ($users as $userLevel => $user) {
    //         if (isset($commissionDistribution[$userLevel])) {
    //             // Calculate the total percentage for the current level
    //             $levelPercentageSum = array_sum($commissionDistribution[$userLevel]);

    //             // Calculate the commission for this level
    //             $levelTotalCommission = $remainingCommission * $levelPercentageSum;

    //             foreach ($commissionDistribution[$userLevel] as $percentage) {
    //                 $commissionForUser = $levelTotalCommission * $percentage;
    //                 $user->Total_sale_commission += $commissionForUser;
    //                 $user->wallet_balance += $commissionForUser;
    //                 $user->save();

    //                 echo "User {$user->user->name} (level {$userLevel}) receives {$commissionForUser} commission.\n";
    //                 break; // Apply the first percentage for the current level
    //             }

    //             // Update remaining commission
    //             $remainingCommission -= $levelTotalCommission;

    //             // Ensure the remaining commission does not go below zero
    //             if ($remainingCommission < 0) {
    //                 $remainingCommission = 0;
    //             }
    //         }
    //     }

    //     return true; // Return success or appropriate value
    // }

}
