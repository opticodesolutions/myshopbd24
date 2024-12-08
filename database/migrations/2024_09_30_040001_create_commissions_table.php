<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommissionsTable extends Migration
{
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('sale_id')->nullable();
            $table->decimal('direct_bonus', 10, 2)->default(0.00);

            $table->decimal('downline_bonus', 10, 2)->default(0.00);
            $table->decimal('matching_bonus', 10, 2)->default(0.00);
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('commissions');
    }
}
