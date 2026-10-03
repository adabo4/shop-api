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

            //Basic identification
            $table->string('product_code')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('ean', 14)->nullable()->unique();
            $table->string('sukl_code')->nullable();

            // Product classification
            $table->string('product_type');

            // Commerce
            $table->decimal('price', 10, 2);
            $table->boolean('is_active')->default(true);

            // Product information
            $table->text('description')->nullable();
            $table->text('composition')->nullable();
            $table->text('dosage')->nullable();
            $table->text('usage')->nullable();
            $table->text('warnings')->nullable();

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
