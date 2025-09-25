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
        Schema::table('t_order_items', function (Blueprint $table) {
            // Ensure indexes for FK and add constraint
            if (Schema::hasColumn('t_order_items', 'm_product_variant_id')) {
                $table->foreign('m_product_variant_id', 't_order_items_m_product_variant_id_foreign')
                    ->references('id')->on('m_product_variants')
                    ->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_order_items', function (Blueprint $table) {
            try {
                $table->dropForeign('t_order_items_m_product_variant_id_foreign');
            } catch (\Throwable $e) {
                // ignore if not exists
            }
        });
    }
};
