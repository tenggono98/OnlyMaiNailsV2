<?php

use App\Models\User;
use App\Models\MService;
use App\Models\TBooking;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('t_d_bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TBooking::class);
            $table->foreignIdFor(MService::class)->nullable();
            $table->string('costume_service')->nullable();
            $table->integer('price')->nullable();
            $table->foreignIdFor(User::class,'created_by')->nullable();
            $table->foreignIdFor(User::class,'updated_by')->nullable();
            $table->enum('status',[1,0])->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_d_bookings');
    }
};
