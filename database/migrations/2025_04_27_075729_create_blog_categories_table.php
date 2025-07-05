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
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->json('short_desc')->nullable();
            $table->json('long_desc')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_image')->nullable();
            $table->json('slug')->nullable();
            $table->json('meta_title',255)->nullable();
            $table->json('meta_desc')->nullable();
            $table->enum('status', ['published', 'inactive'])->default('published');
            $table->boolean('index')->nullable()->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
