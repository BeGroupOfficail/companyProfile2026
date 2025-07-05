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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('blog_category_id');
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

            // Add foreign key constraint
            $table->foreign('blog_category_id')
                ->references('id')
                ->on('blog_categories')
                ->onDelete('cascade'); // Deletes blogs when blog categories is deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
