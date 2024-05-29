<?php

use App\Models\MServiceCategory;
use App\Models\User;
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
        Schema::create('m_services', function (Blueprint $table) {
            $table->id();
            $table->string('name_service');
            $table->bigInteger('price_service');
            $table->enum('is_merge',[1,0])->default(0);
            $table->foreignIdFor(MServiceCategory::class);
            $table->foreignIdFor(User::class,'created_by')->nullable();
            $table->foreignIdFor(User::class,'updated_by')->nullable();
            $table->enum('status',[true,false])->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_services');
    }
};
