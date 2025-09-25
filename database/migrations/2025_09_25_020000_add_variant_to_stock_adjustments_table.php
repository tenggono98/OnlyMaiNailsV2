<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('m_product_stock_adjustments', function (Blueprint $table) {
            if (!Schema::hasColumn('m_product_stock_adjustments', 'm_product_variant_id')) {
                $table->unsignedBigInteger('m_product_variant_id')->nullable()->after('m_product_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('m_product_stock_adjustments', function (Blueprint $table) {
            if (Schema::hasColumn('m_product_stock_adjustments', 'm_product_variant_id')) {
                $table->dropColumn('m_product_variant_id');
            }
        });
    }
};


