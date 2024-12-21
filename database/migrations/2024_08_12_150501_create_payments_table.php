<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->text('notes')->nullable();
            $table->string('created_by_sms')->nullable();
            $table->unsignedBigInteger('created_by_user_id')->nullable();
            $table->enum('created_by', ['agent', 'super-admin'])->nullable();
            $table->enum('payment_method', ['cash', 'Bkash'])->nullable();
            $table->unsignedBigInteger('account_id')->nullable();
            $table->string('transaction_id')->nullable();
            $table->decimal('amount', 15, 2);
            $table->enum('type', ['topup', 'withdraw']);
            $table->enum('status', ['pending', 'success', 'failed', 'refund']);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
