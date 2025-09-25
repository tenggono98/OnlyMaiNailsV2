<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('t_order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('t_order_id')->constrained('t_orders')->onDelete('cascade');
            $table->foreignId('m_product_id')->constrained('m_products');
            $table->foreignId('m_product_variant_id')->nullable()->constrained('m_product_variants');
            $table->string('name');
            $table->decimal('price', 12, 2);
            $table->unsignedInteger('qty');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_order_items');
    }
};


