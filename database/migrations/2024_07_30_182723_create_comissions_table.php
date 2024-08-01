<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComissionsTable extends Migration
{
    public function up()
    {
        Schema::create('comissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products');
            $table->double('amount');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('comissions');
        Schema::dropIfExists('products');
    }
}

