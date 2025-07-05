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
        Schema::create('sliders', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('text')->nullable();
            $table->string('link')->nullable();
            $table->string('lang', 10); // Assuming language codes like 'en', 'ar' etc.
            $table->enum('status', ['published', 'inactive'])->default('inactive');
            $table->timestamps();
            $table->softDeletes();

            $table->index('lang');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
