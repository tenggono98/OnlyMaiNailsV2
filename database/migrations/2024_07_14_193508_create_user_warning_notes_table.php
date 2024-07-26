<?php

use App\Models\User;
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
        Schema::create('user_warning_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class,'note_for');
            $table->text('description_warning_note');
            $table->foreignIdFor(User::class,'created_by');
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
        Schema::dropIfExists('user_warning_notes');
    }
};
