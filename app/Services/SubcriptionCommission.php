<?php

namespace App\Services;

use App\Helpers\NinePercentCommision;
use App\Models\Customer;
use App\Models\Commission;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SubcriptionCommission
{
    public function distributeSubscriptionDownlineBonus(Sale $sale)
    {
        $totalBonus = 1300; // Total amount to distribute
        $bonusPerLevel = 25; // Amount per user per level
        $maxLevels = 16; // Maximum levels to cover

        $user = User::find($sale->customer_id); // Find the user based on customer_id (which references users)



        if (!$user || !$user->customer) {
            return; // Exit if no valid user or customer is found
        }

        $parent = $this->getParent($user->customer); // Get the parent customer

        if ($parent) {
            // Start the bonus distribution
            $this->distributeDownlineBonus($parent, $sale, $bonusPerLevel, $totalBonus, $maxLevels, 1);
        }
    }

    private function distributeDownlineBonus($parent, $sale, $bonusPerLevel, &$remainingBonus, $maxLevels, $currentLevel)
    {
        if (!$parent || $currentLevel > $maxLevels || $remainingBonus < $bonusPerLevel) {
            return; // Stop if no parent, max levels reached, or no remaining bonus
        }

        // Distribute bonus to the current parent
        $this->processDownlineBonus($parent, $sale, $bonusPerLevel);

        // Deduct the bonus from the remaining pool
        $remainingBonus -= $bonusPerLevel;

        // Fetch the children of the current parent
        $children = $this->getChildren($parent);

        // Distribute bonus to the children
        foreach ($children as $child) {
            $this->distributeDownlineBonus($child, $sale, $bonusPerLevel, $remainingBonus, $maxLevels, $currentLevel + 1);
        }
    }
    
    private function processDownlineBonus($customer, $sale, $amountn)
    {
        NinePercentCommision::AmdinCommistion($amountn);
        $amount = NinePercentCommision::CustomerCommistion($amountn);
        // Increment wallet balance for the customer
        $customer->increment('wallet_balance', $amount);

        // Create a transaction record
        Transaction::create([
            'user_id' => $customer->user_id, // Customer's user ID
            'sale_id' => $sale->id,
            'amount' => $amount,
            'transaction_type' => 'subscription_bonus',
        ]);

        // Update the commission record for the customer
        $commission = Commission::firstOrNew(['customer_id' => $customer->id]);
        $commission->subscription_bonus = ($commission->subscription_bonus ?? 0) + $amount;
        $commission->save();
    }

    private function getParent(Customer $customer)
    {
        return $customer->parent; // Assuming a 'parent' relationship is defined in the Customer model
    }

    private function getChildren(Customer $parent)
    {
        return $parent->children; // Assuming a 'children' relationship is defined in the Customer model
    }
}
