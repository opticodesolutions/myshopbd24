<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->decimal('Total_Sales', 10, 2)->default(0.00);
            $table->string('refer_code', 10)->nullable();
            $table->string('refer_by', 10)->nullable();
            $table->string('position_parent', 10)->nullable();
            $table->enum('position', ['left', 'right'])->nullable();
            $table->unsignedBigInteger('level')->nullable();
            $table->decimal('Total_sale_commission', 10, 2)->default(0.00);
            $table->decimal('matching_commission', 10, 2)->default(0.00);
            $table->decimal('wallet_balance', 10, 2)->default(0.00);
            $table->date('subscription_start_date')->nullable();
            $table->date('subscription_end_date')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('sale_id')->references('id')->on('sales')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
