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
        Schema::table('m_products', function (Blueprint $table) {
            // Add missing columns if they don't exist
            if (!Schema::hasColumn('m_products', 'sku')) {
                $table->string('sku')->nullable();
            }
            if (!Schema::hasColumn('m_products', 'name_service')) {
                $table->string('name_service');
            }
            if (!Schema::hasColumn('m_products', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('m_products', 'price_service')) {
                $table->decimal('price_service', 12, 2)->default(0);
            }
            if (!Schema::hasColumn('m_products', 'stock')) {
                $table->unsignedInteger('stock')->default(0);
            }
            if (!Schema::hasColumn('m_products', 'image_path')) {
                $table->string('image_path')->nullable();
            }
            if (!Schema::hasColumn('m_products', 'status')) {
                $table->boolean('status')->default(true);
            }
        });

        // Create a unique index for sku (SQLite supports creating indexes)
        if (!Schema::hasColumn('m_products', 'sku')) {
            // nothing to index
        } else {
            try {
                Schema::table('m_products', function (Blueprint $table) {
                    $table->unique('sku', 'm_products_sku_unique');
                });
            } catch (\Throwable $e) {
                // Ignore if index already exists or driver limitations
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Best-effort rollback: drop unique index; dropping columns on SQLite can be limited
        try {
            Schema::table('m_products', function (Blueprint $table) {
                $table->dropUnique('m_products_sku_unique');
            });
        } catch (\Throwable $e) {
            // ignore
        }
    }
};
