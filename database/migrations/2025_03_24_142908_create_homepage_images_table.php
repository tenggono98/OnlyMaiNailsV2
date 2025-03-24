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
        Schema::create('homepage_images', function (Blueprint $table) {
            $table->id();
            $table->string('image_path');
            $table->string('alt_text')->nullable();
            $table->integer('display_order')->default(0);
            $table->enum('section', ['header', 'promo']); // To differentiate between header images and promo images
            $table->enum('status', [1, 0])->default(1);
            $table->foreignIdFor(User::class, 'created_by')->nullable();
            $table->foreignIdFor(User::class, 'updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_images');
    }
};
