<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncentiveIncomeTable extends Migration
{
    public function up()
    {
        Schema::create('incentive_incomes', function (Blueprint $table) {
            $table->id();
            $table->string('designation_name');
            $table->integer('child_and_children');
            $table->integer('matching_sale');
            $table->decimal('amount', 15, 2);
            $table->string('text')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('incentive_incomes');
    }
}
