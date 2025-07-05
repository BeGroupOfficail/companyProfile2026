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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->json('why_choose_us')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_image')->nullable();
            $table->string('banner')->nullable();
            $table->string('alt_banner')->nullable();
            $table->json('slug')->nullable();
            $table->json('meta_title',255)->nullable();
            $table->json('meta_desc')->nullable();
            $table->boolean('index')->nullable()->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
