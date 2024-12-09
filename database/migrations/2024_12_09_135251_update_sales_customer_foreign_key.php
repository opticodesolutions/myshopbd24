<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateSalesCustomerForeignKey extends Migration
{
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Drop the old foreign key constraint for customer_id
            $table->dropForeign(['customer_id']);

            // Add the new foreign key constraint for customer_id
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            // Drop the new foreign key constraint
            $table->dropForeign(['customer_id']);

            // Add the old foreign key constraint to reference users table
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
}
