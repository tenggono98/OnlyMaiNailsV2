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
        Schema::create('product_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('m_product_id')->constrained('m_products')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('rating')->unsigned()->min(1)->max(5); // 1-5 star rating
            $table->text('review_text')->nullable();
            $table->boolean('is_approved')->default(false); // Admin approval for reviews
            $table->boolean('is_verified_purchase')->default(false); // If user actually bought the product
            $table->timestamps();
            
            // Ensure one review per user per product
            $table->unique(['m_product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_reviews');
    }
};
