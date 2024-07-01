<?php

use App\Models\TBooking;
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
        Schema::create('review_users', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(TBooking::class,'booking_uuid');
            $table->enum('is_show_review',[1,0])->default(0);
            $table->text('description_review');
            $table->foreignIdFor(User::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_users');
    }
};
