<?php

use App\Models\TDSchedule;
use App\Models\TSchedule;
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
        Schema::create('t_bookings', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 36);
            $table->bigInteger('deposit_price_booking');
            $table->bigInteger('total_price_booking');
            $table->bigInteger('total_price_after_tax_booking')->nullable();
            $table->integer('qty_people_booking');
            $table->string('code_booking');
            $table->enum('is_deposit_paid',[1,0])->default(0);
            $table->bigInteger('reschedule_booking_original_id')->nullable();
            $table->foreignIdFor(TSchedule::class);
            $table->foreignIdFor(TDSchedule::class);
            $table->foreignIdFor(User::class)->nullable();
            $table->foreignIdFor(User::class,'created_by')->nullable();
            $table->foreignIdFor(User::class,'updated_by')->nullable();
            $table->enum('status',[1,0,'reschedule','cancel','completed'])->default(1);
            $table->enum('confirm_payment',[1,0])->default(0);
            $table->enum('reschedule_flag_booking',[1,0])->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_bookings');
    }
};
