<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('subcriptio_renews', function (Blueprint $table) {
            $table->id(); 
            $table->unsignedBigInteger('user_id');
            $table->date('renewal_date');
            $table->string('payment_status')->default('pending'); 
            $table->decimal('renewal_amount', 8, 2); 
            $table->string('remarks');
            $table->unsignedBigInteger('subscription_id');
            $table->foreign('subscription_id')
            ->references('id')
                ->on('subscriptions')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->string('payment_method')->nullable();
            $table->timestamps(); 
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subcriptio_renews');
    }
};
