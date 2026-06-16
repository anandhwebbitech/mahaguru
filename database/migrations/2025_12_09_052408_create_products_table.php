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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('product_name');
            $table->string('category');
            $table->decimal('price', 10, 2);
            $table->string('material');
            $table->json('size'); // multi-select            
            $table->json('color'); // for multiple colors
            $table->decimal('discount', 5, 2)->nullable();
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->json('images'); // multiple images
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
