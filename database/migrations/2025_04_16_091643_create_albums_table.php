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
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('text')->nullable();
            $table->enum('album_type', ['images', 'videos'])->default('images');
            $table->string('type'); // Could be enum if you have specific types
            $table->unsignedBigInteger('type_value_id')->nullable();
            $table->enum('status', ['published', 'inactive'])->default('inactive');
            $table->timestamps();
            $table->softDeletes();

            $table->index('type');
            // $table->index('lang');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
