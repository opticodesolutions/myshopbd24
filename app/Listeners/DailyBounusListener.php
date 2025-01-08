<?php

namespace App\Listeners;

use App\Events\DailyBonusDistibutte;
use App\Helpers\NinePercentCommision;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DailyBounusListener implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * Handle the event.
     */
    public function handle(DailyBonusDistibutte $event): void
    {
        $sale = $event->sale;
        $saleDateTime = $sale->created_at;
        $userCount = Customer::where('refer_code', '!=', null)
            ->where('created_at', '>=', $saleDateTime)->count();
        // $Product = Product::find($sale->product_id);
        $profit = 400;
        $distributeAmount = $profit / $userCount;
        DB::beginTransaction();
        try {
            Customer::where('refer_code', '!=', null)
            ->where('subscription_end_date' , '>=', now())
            ->where('created_at', '>=', $saleDateTime)
            ->chunk(500, function ($users) use ($distributeAmount, $sale) {
                foreach ($users as $user) {
                    if ($user) {
                        NinePercentCommision::AmdinCommistion($distributeAmount);
                        $amount = NinePercentCommision::CustomerCommistion($distributeAmount);
                        $user->wallet_balance += $amount; //User == Customers
                        Transaction::create([
                            'user_id' => $user->user_id,
                            'sale_id' => $sale->id,
                            'amount' => $amount,
                            'transaction_type' => 'daily_commission',
                        ]);
                    }
                }
            });
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error distributing daily bonus: ' . $e->getMessage());
        }
    }
}
