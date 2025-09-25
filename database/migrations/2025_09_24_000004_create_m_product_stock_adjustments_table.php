<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('m_product_stock_adjustments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_product_id')->constrained('m_products')->onDelete('cascade');
            $table->integer('delta');
            $table->string('reason')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('m_product_stock_adjustments');
    }
};


