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
        Schema::create('album_images', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('alt_image')->nullable();
            $table->foreignId('album_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['published', 'inactive'])->default('inactive');
            $table->timestamps();
           // $table->softDeletes();

            $table->index('album_id');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('album_images');
    }
};
