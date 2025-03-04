<?php
namespace App\Services;

use App\Helpers\Helpers;
use App\Helpers\NinePercentCommision;
use App\Helpers\SubGenerationHelper;
use App\Models\Account;
use App\Models\Customer;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubscriptionService
{
    private $subscription;
    private $Helpers;

    public function __construct(Subscription $subscription, Helpers $Helpers)
    {
        $this->subscription = $subscription;
        $this->Helpers = $Helpers;
    }

    public function DistibuteCommssion($sales){
        try{
            DB::beginTransaction();
            $this->handleTransaction($sales->user_id, $sales->total_amount, 'subscription_purchase');
            $this->RefferCommission($sales->user_id, $sales->subscription->ref_income);
            $this->admin_profit($sales);
            $this->admin_profit_salary($sales);
            $this->DailyBonus($sales);
            $this->InsectiveIncome($sales);
            DB::commit();
            return redirect()->back()->with('success', 'Commission Distributed Successfully.');
        }catch(\Exception $e){
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
    }

    private function InsectiveIncome($sales)
    {
        $TotalAmount = $sales->subscription->insective_income;
        $qualifiedUsers = [];
        // Filter users with more than 4 total referred users
        foreach ($this->GetAllUsers() as $user) {
            if (SubGenerationHelper::getTotalUsersForRoot(Customer::where('user_id', $user)->where('subscription_end_date', '>', now())->value('refer_code')) > 4) {
                $qualifiedUsers[] = $user;
            }
        }
        // Calculate the amount to distribute
        $totalQualified = count($qualifiedUsers);
        if ($totalQualified === 0) return; // Exit if no users qualify

        $amountn = $TotalAmount / $totalQualified;
        // Update wallet balances and handle transactions
        foreach ($qualifiedUsers as $userId) {
            NinePercentCommision::AmdinCommistion($amountn);
            $amount = NinePercentCommision::CustomerCommistion($amountn);
            $currentBalance = Customer::where('user_id', $userId)->value('wallet_balance');
            Customer::where('user_id', $userId)->update(['wallet_balance' => $currentBalance + $amount]);
            $this->handleTransaction($userId, $amount, 'insective_income');
        }
    }

    private function DailyBonus($sales){
        $totalUser = $this->GetAllUsers()->count();
        $amountn = $sales->subscription->daily_bonus / $totalUser;
        foreach ($this->GetAllUsers() as $user) {
            NinePercentCommision::AmdinCommistion($amountn);
            $amount = NinePercentCommision::CustomerCommistion($amountn);
            $currentBalance = Customer::where('user_id', $user)
            ->where('subscription_end_date', '>', now())
            ->value('wallet_balance');
            Customer::where('user_id', $user)->update(['wallet_balance' => $currentBalance + $amount]);
            $this->handleTransaction($user, $amount, 'daily_bonus');
        }
    }
    private function admin_profit_salary($sales){
        $transection = $this->handleTransaction(Auth::id(), $sales->subscription->admin_profit_salary, 'admin_profit_salary');
        Account::create([
            'amount' => $sales->subscription->admin_profit_salary,
            'type' => 'debit',
            'tran_id' => $transection,
            'approved_by' => Auth::id()
        ]);
    }
    private function admin_profit($sales){
        $transection = $this->handleTransaction(Auth::id(), $sales->subscription->admin_profit, 'admin_profit');
        Account::create([
            'amount' => $sales->subscription->admin_profit,
            'type' => 'debit',
            'tran_id' => $transection,
            'approved_by' => Auth::id()
        ]);
    }
    private function RefferCommission($user_id, $amountn){
        NinePercentCommision::AmdinCommistion($amountn);
        $amount = NinePercentCommision::CustomerCommistion($amountn);
        $user = Customer::where('user_id', $user_id)
        ->where('subscription_end_date', '>', now())
        ->first();
        if ($user){
            $user->wallet_balance = $user->wallet_balance + $amount;
            $user->save();
            $this->handleTransaction($user_id, $amount, 'reffer_commission');
        }else{
            NinePercentCommision::UserDeactive($amount);
        }
    }

    private function handleTransaction($user_id, $amount, $transaction_type){
        $transection = Transaction::create([
            'user_id' => $user_id, 
            'amount' => $amount,
            'transaction_type' => $transaction_type,
        ]);
        return $transection->id;
    }

    private function GetAllUsers()
    {
        $customer = Customer::pluck('user_id');
        return $customer;
    }
}