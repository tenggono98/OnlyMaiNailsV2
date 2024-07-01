<?php

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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title_notification');
            $table->text('description_notification');
            $table->string('referance_id')->nullable();
            $table->enum('for_role_notification',['user','admin']);
            $table->foreignIdFor(User::class,'notif_for')->nullable();
            $table->foreignIdFor(User::class,'created_by')->nullable();
            $table->text('url')->nullable();
            $table->enum('is_read',[1,0])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
