<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_product_id')->constrained('m_products')->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('name');
            $table->decimal('price', 12, 2)->nullable();
            $table->unsignedInteger('stock')->default(0);
            $table->string('image_path')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_product_variants');
    }
};


