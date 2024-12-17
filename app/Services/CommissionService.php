<?php

namespace App\Services;

use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use App\Models\Purchase;
use App\Models\Commission;
use App\Models\Transaction;
use App\Models\MatchingCommission;
use Exception;
use Illuminate\Support\Facades\DB;

class CommissionService
{
   private $subcriptionCommission;
    public function __construct(SubcriptionCommission $subcriptionCommission){
        $this->subcriptionCommission = $subcriptionCommission;
    }
    /**
     * Calculate commissions for a sale.
     */
    public function calculateCommissions(Sale $sale)
    {
       DB::beginTransaction();
       try{
            $this->subcriptionCommission->distributeSubcriptionDownlineBonus($sale);
            $this->sellTransactions($sale);
            $this->handleSubscriptionFee($sale);
            $this->distributeDirectBonus($sale);
            $this->distributeDownlineBonus($sale);
           
            DB::commit();
       }catch(Exception $e){
           DB::rollBack();
           return redirect()->back()->with('error', $e->getMessage());
       }
    }

    private function sellTransactions(Sale $sale)
    {
        $product = Product::find($sale->product_id);

        $purchase = Purchase::create([
            'user_id' => $sale->customer_id,  // Customer makes the purchase
            'product_id' => $sale->product_id,
            'commission' => $product->purchase_commission,
        ]);

        // Create a transaction record for the purchase
        Transaction::create([
            'user_id' => $sale->customer_id,  // Admin transaction for purchase commission
            'sale_id' => $sale->id,
            'purchase_id' => $purchase->id,
            'amount' => $product->purchase_commission,
            'transaction_type' => 'purchase_commission',
        ]);


        // Update the customer's wallet balance
        $purchase_customer = Customer::where('user_id', $sale->customer_id)->first();
        $purchase_customer->wallet_balance += $product->purchase_commission;
        $purchase_customer->save();


        // Create a transaction for the new sale
        Transaction::create([
            'user_id' => $sale->user_id,  // Admin or the seller, depending on the logic
            'sale_id' => $sale->id,
            'purchase_id' => $purchase->id,
            'amount' => $sale->price,
            'transaction_type' => 'new_sale',
        ]);
    }

    /**
     * Handle subscription fee for admin.
     */
    private function handleSubscriptionFee(Sale $sale)
    {
        $subscriptionFee = 1300;

        Transaction::create([
            'user_id' => $sale->customer_id, // Admin transaction
            'sale_id' => $sale->id,
            'amount' => $subscriptionFee,
            'transaction_type' => 'admin_subscription_fee',
        ]);
    }

    /**
     * Distribute direct bonus to the parent.
     */
    private function distributeDirectBonus(Sale $sale)
    {
        $directBonus = 1000;
        $user = User::find($sale->customer_id); // Find the user based on customer_id (which references users)

        if (!$user || !$user->customer) {
            // Handle case where user or associated customer doesn't exist
            return;
        }

        $customer = $user->customer; // Get the associated Customer model
        $parent = $this->getParent($customer);

        if ($parent) {
            $parent->increment('wallet_balance', $directBonus);

            $pUser = DB::table('customers')->find($parent->id); // Find the user based on customer_id (which references users)

            Transaction::create([
                'user_id' => $sale->user_id, // P_user_id
                'sale_id' => $sale->id,
                'amount' => $directBonus,
                'transaction_type' => 'direct_bonus',
            ]);

            Commission::create([
                'customer_id' => $parent->id, // P_user_c_id
                'sale_id' => $sale->id,
                'direct_bonus' => $directBonus,
                'left_amount' => 0,
                'right_amount' => 0,
            ]);
        }
    }


    /**
     * Distribute downline bonuses up the referral chain.
     */
    private function distributeDownlineBonus(Sale $sale)
    {
        $downlineBonus = 1500;
        $remainingBonus = $downlineBonus;
        $childCommission = 250;
        $matchingLevels = 11;
        $levelsCovered = 0;

        $user = User::find($sale->customer_id); // Find the user based on customer_id (which references users)

        if (!$user || !$user->customer) {
            // Handle case where user or associated customer doesn't exist
            return;
        }

        $customer = $user->customer; // Get the associated Customer model
        $parent = $this->getParent($customer);

        while ($parent && $remainingBonus >= $childCommission && $levelsCovered < $matchingLevels) {
            $this->processDownlineBonus($parent, $sale, $childCommission, $customer->position);

            $remainingBonus -= $childCommission;
            $levelsCovered++;

            // Move to the next level in the referral chain
            $customer = $parent;
            $parent = $this->getParent($customer);
        }

        $this->handleRemainingBonus($sale, $remainingBonus, $levelsCovered, $matchingLevels);
    }

    /**
     * Process downline bonus for a single level.
     */
    private function processDownlineBonus($parent, $sale, $amount, $position)
    {
        // Fetch the parent's commission record or create a new one if it doesn't exist
        $commission = Commission::firstOrNew(['customer_id' => $parent->id]);
        $pUser = DB::table('customers')->find($parent->id); // Find the user based on customer_id (which references users)


        if ($position === 'left') {
            // Increment the left amount
            $commission->left_amount += $amount;

            Transaction::create([
                'user_id' => $sale->user_id,
                'sale_id' => $sale->id,
                'amount' => $amount,
                'transaction_type' => 'downline_left_hold_bonus',
            ]);
        } elseif ($position === 'right') {
            // Increment the right amount
            $commission->right_amount += $amount;

            Transaction::create([
                'user_id' => $sale->user_id,
                'sale_id' => $sale->id,
                'amount' => $amount,
                'transaction_type' => 'downline_right_hold_bonus',
            ]);
        }

        // Check if both left and right are sufficient to pay the downline bonus
        if ($commission->left_amount >= $amount && $commission->right_amount >= $amount) {
            // Distribute the bonus
            $parent->increment('wallet_balance', $commission->left_amount + $commission->right_amount);

            // Deduct the amount from left and right to balance out the distribution
            $commission->left_amount -= $amount;
            $commission->right_amount -= $amount;

            Transaction::create([
                'user_id' => $sale->user_id,
                'sale_id' => $sale->id,
                'amount' => $amount * 2,
                'transaction_type' => 'downline_bonus',
            ]);
        }

        // Save the updated commission record
        $commission->save();
    }


    /**
     * Handle remaining bonus not distributed within matching levels.
     */
    private function handleRemainingBonus($sale, $remainingBonus, $levelsCovered, $matchingLevels)
    {
        if ($levelsCovered < $matchingLevels) {
            Transaction::create([
                'user_id' => $sale->customer_id, // Admin transaction
                'sale_id' => $sale->id,
                'amount' => $remainingBonus,
                'transaction_type' => 'admin_profit_from_matching_commission',
            ]);
        }
    }

    /**
     * Get the parent of the customer in the referral chain.
     */
    private function getParent(Customer $customer)
    {
        return $customer->parent; // Assuming a 'parent' relationship is defined in the Customer model.
    }
}
