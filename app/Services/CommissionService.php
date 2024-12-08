<?php

namespace App\Services;

use App\Models\Commission;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\MatchingCommission;

class CommissionService
{
    public function calculateCommissions(Sale $sale)
    {
        $customer = $sale->customer;

        // Subscription Fee Handling
        $subscriptionFee = 1300;
        $subscriptionCommissionPerUser = 25;
        $remainingSubscriptionBonus = 0;

        // Add subscription profit to admin
        $adminProfit = $subscriptionFee;
        Transaction::create([
            'user_id' => null, // Admin transaction
            'sale_id' => $sale->id,
            'amount' => $subscriptionFee,
            'transaction_type' => 'admin_subscription_fee',
        ]);

        // Direct Bonus
        $directBonus = 1000;
        $customer->increment('wallet_balance', $directBonus);
        Transaction::create([
            'user_id' => $customer->id,
            'sale_id' => $sale->id,
            'amount' => $directBonus,
            'transaction_type' => 'direct_bonus',
        ]);
        Commission::create([
            'customer_id' => $customer->id,
            'sale_id' => $sale->id,
            'direct_bonus' => $directBonus,
            'left_amount' => 0,
            'right_amount' => 0,
        ]);

        // Downline Bonus
        $downlineBonus = 1500;
        $remainingBonus = $downlineBonus;
        $childCommission = 250;

        // Matching Commission and Distribution up to 10 levels
        $matchingBonus = 0;
        $matchingLevels = 10;
        $levelsCovered = 0;
        $parent = $this->getParent($customer);

        while ($parent && $remainingBonus >= $childCommission && $levelsCovered < $matchingLevels) {
            // Determine the position of the user (left or right)
            $position = $customer->position; // Get the position (left or right)

            if ($position === 'left') {
                // Add the commission to left_amount
                $parent->increment('wallet_balance', $childCommission);
                Transaction::create([
                    'user_id' => $parent->id,
                    'sale_id' => $sale->id,
                    'amount' => $childCommission,
                    'transaction_type' => 'downline_bonus',
                ]);
                Commission::create([
                    'customer_id' => $parent->id,
                    'sale_id' => $sale->id,
                    'downline_bonus' => $childCommission,
                    'left_amount' => $childCommission,  // Add commission to left_amount
                    'right_amount' => 0,
                ]);
            } else {
                // Add the commission to right_amount
                $parent->increment('wallet_balance', $childCommission);
                Transaction::create([
                    'user_id' => $parent->id,
                    'sale_id' => $sale->id,
                    'amount' => $childCommission,
                    'transaction_type' => 'downline_bonus',
                ]);
                Commission::create([
                    'customer_id' => $parent->id,
                    'sale_id' => $sale->id,
                    'downline_bonus' => $childCommission,
                    'left_amount' => 0,
                    'right_amount' => $childCommission,  // Add commission to right_amount
                ]);
            }

            $remainingBonus -= $childCommission;
            $matchingBonus += $childCommission;
            $levelsCovered++;

            // Save Matching Commission for each level
            MatchingCommission::create([
                'customer_id' => $parent->id,
                'sale_id' => $sale->id,
                'amount' => $childCommission,
                'level' => $levelsCovered,
            ]);

            // Move to the parent
            $parent = $this->getParent($parent);
        }

        // Check if matching levels are less than 10
        $matchingLevelsCovered = $levelsCovered;
        if ($matchingLevelsCovered < $matchingLevels) {
            // Calculate the remaining matching bonus
            $remainingMatchingBonus = $remainingBonus;

            // Add the remaining matching bonus directly as admin profit
            Transaction::create([
                'user_id' => null, // Admin transaction
                'sale_id' => $sale->id,
                'amount' => $remainingMatchingBonus,
                'transaction_type' => 'admin_profit_from_matching_commission',
            ]);
        }

        // Check if subscription levels are less than 15
        $subscriptionLevelsCovered = $levelsCovered;
        if ($subscriptionLevelsCovered < 15) {
            // Calculate the remaining subscription bonus
            $remainingSubscriptionBonus = (15 - $subscriptionLevelsCovered) * $subscriptionCommissionPerUser;

            // Add the remaining subscription bonus directly as admin profit
            Transaction::create([
                'user_id' => null, // Admin transaction
                'sale_id' => $sale->id,
                'amount' => $remainingSubscriptionBonus,
                'transaction_type' => 'admin_profit_from_subscription_bonus',
            ]);
        }

        // Remaining Matching Bonus
        $remainingMatchingBonus = $remainingBonus;
        Transaction::create([
            'user_id' => null, // Admin transaction
            'sale_id' => $sale->id,
            'amount' => $remainingMatchingBonus,
            'transaction_type' => 'admin_profit_from_matching_commission',
        ]);
    }

    private function getParent(Customer $customer)
    {
        if ($customer->refer_by) {
            return Customer::where('refer_code', $customer->refer_by)->first();
        }
        return null;
    }
}
