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
        Schema::table('t_invoices', function (Blueprint $table) {
            if (!Schema::hasColumn('t_invoices', 'pdf_path')) {
                $table->string('pdf_path')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('t_invoices', function (Blueprint $table) {
            if (Schema::hasColumn('t_invoices', 'pdf_path')) {
                $table->dropColumn('pdf_path');
            }
        });
    }
};
