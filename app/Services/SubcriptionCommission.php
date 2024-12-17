<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Commission;
use App\Models\Sale;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class SubcriptionCommission
{
    public function distributeSubcriptionDownlineBonus(Sale $sale)
    {
        $downlineBonus = 1300;
        $remainingBonus = $downlineBonus;
        $childCommission = 25;
        $matchingLevels = 16;
        $levelsCovered = 0;

        $user = User::find($sale->customer_id); 

        if (!$user || !$user->customer) {
            return;
        }

        $customer = $user->customer; // Get the associated Customer model parent custop
        $parent = $this->getParent($customer);

        while ($parent && $remainingBonus >= $childCommission && $levelsCovered < $matchingLevels) {
            $this->SubcriptionProcessDownlineBonus($parent, $sale, $childCommission);

            $remainingBonus -= $childCommission;
            $levelsCovered++;

            // Move to the next level in the referral chain
            $customer = $parent;
            $parent = $this->getParent($customer);
        }

        $this->handleRemainingSubscriptionBonus($sale, $remainingBonus, $levelsCovered, $matchingLevels);
    }


    private function SubcriptionProcessDownlineBonus($parent, $sale, $amount,)
    {
        // Fetch the parent's commission record or create a new one if it doesn't exist
        $commission = Commission::firstOrNew(['customer_id' => $parent->id]);
        $pUser = DB::table('customers')->find($parent->id); // Find the user based on customer_id (which references users)

    
            // Distribute the bonus
            $parent->increment('wallet_balance', $amount);

            Transaction::create([
                'user_id' => $sale->user_id,
                'sale_id' => $sale->id,
                'amount' => $amount,
                'transaction_type' => 'subscription_bonus',
            ]);
        $commission->save();
    }

    private function handleRemainingSubscriptionBonus($sale, $remainingBonus, $levelsCovered, $matchingLevels)
    {
        if ($levelsCovered < $matchingLevels) {
            Transaction::create([
                'user_id' => $sale->customer_id, // Admin transaction
                'sale_id' => $sale->id,
                'amount' => $remainingBonus,
                'transaction_type' => 'admin_profit_from_Subcription_commission',
            ]);
        }
    }


    private function getParent(Customer $customer)
    {
        return $customer->parent; // Assuming a 'parent' relationship is defined in the Customer model.
    }
}