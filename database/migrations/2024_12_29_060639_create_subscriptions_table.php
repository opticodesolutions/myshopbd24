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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->decimal('amount', 15, 2);
            $table->decimal('per_person', 15, 2)->nullable();
            $table->integer('lavel')->nullable();
            $table->decimal('ref_income', 15, 2);
            $table->decimal('insective_income', 15, 2);
            $table->decimal('daily_bonus', 15, 2);
            $table->decimal('admin_profit_salary', 15, 2)->comment('Admin profit == Salary Amount');
            $table->decimal('admin_profit');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
