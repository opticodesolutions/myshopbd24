<?php
namespace App\Helpers;

use App\Models\Account;
use App\Models\Transaction;

class NinePercentCommision // Nine mins Eight Percent Commition 
{
    /**
     * Calculate and store admin commission for a given sale amount.
     *
     * @param int $total The total amount of the sale.
     */
    public static function AmdinCommistion($total)
    {
        $finalAmount = ($total * 8) / 100;
        $trancsaction = Transaction::create([
            'user_id' => env('ADMIN_ID'),
            'sale_id' => null,
            'amount' => $finalAmount,
            'transaction_type' => 'Admin 8% Commission',
        ]);
        Account::create([
            'tran_id' => $trancsaction->id,
            'amount' => $finalAmount,
            'type' => 'debit',
            'approved_by' => env('ADMIN_ID')
        ]);
    }

    public static function CustomerCommistion($total)
    {
        $finalAmount = ($total * 92) / 100;
        return $finalAmount;
    }
}