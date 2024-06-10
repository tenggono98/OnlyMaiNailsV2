<?php

use App\Models\User;
use App\Models\TBooking;
use App\Models\TSchedule;
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
        Schema::create('t_d_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('time');
            $table->enum('is_book',[0,1])->default(0);
            $table->foreignIdFor(TSchedule::class);
            $table->foreignIdFor(TBooking::class)->nullable();
            $table->foreignIdFor(User::class,'created_by')->nullable();
            $table->foreignIdFor(User::class,'updated_by')->nullable();
            $table->enum('status',[1,0])->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_d_schedules');
    }
};
