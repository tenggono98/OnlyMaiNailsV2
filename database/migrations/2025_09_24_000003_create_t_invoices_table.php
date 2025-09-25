<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('t_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->foreignId('t_order_id')->constrained('t_orders')->onDelete('cascade');
            $table->string('invoice_number')->unique();
            $table->decimal('total', 12, 2);
            $table->enum('status', ['draft','issued','paid','void'])->default('draft');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t_invoices');
    }
};


