<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Transaction;
use App\Helpers\NinePercentCommision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mockery;
use Mockery as GlobalMockery;

class NinePercentCommisionTest extends TestCase
{
    /**
     * Test Admin Commission.
     *
     * @return void
     */
    public function testAdminCommistion()
    {
        // Mock the Transaction::create method
        $transactionMock = GlobalMockery::mock('alias:App\Models\Transaction');
        $transactionMock->shouldReceive('create')
            ->once()
            ->with([
                'user_id' => env('ADMIN_ID'),
                'sale_id' => null,
                'amount' => 98, // 9.8% of 1000
                'transaction_type' => 'Admin 9.8% Commission'
            ]);

        // Call the method
        NinePercentCommision::AmdinCommistion(1000);

        // Assert the method was called
        $transactionMock->shouldHaveReceived('create');
    }

    /**
     * Test Customer Commission.
     *
     * @return void
     */
    public function testCustomerCommistion()
    {
        $user_id = 1; // example user_id
        $sale_id = 101; // example sale_id

        // Mock the Transaction::create method
        $transactionMock = GlobalMockery::mock('alias:App\Models\Transaction');
        $transactionMock->shouldReceive('create')
            ->once()
            ->with([
                'user_id' => $user_id,
                'sale_id' => $sale_id,
                'amount' => 902, // 90.2% of 1000
                'transaction_type' => 'Customer 9.8% Commission'
            ]);

        // Call the method
        NinePercentCommision::CustomerCommistion(1000, $user_id, $sale_id);

        // Assert the method was called
        $transactionMock->shouldHaveReceived('create');
    }
}
