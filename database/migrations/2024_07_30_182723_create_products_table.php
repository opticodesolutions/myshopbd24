<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('product_code')->unique();
            $table->string('name');
            $table->double('price');
            $table->double('discount_price')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('brand_id')->constrained('brands');
            $table->integer('stock');
            $table->foreignId('image')->constrained('medias');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('brands');
        Schema::dropIfExists('medias');


    }
}

