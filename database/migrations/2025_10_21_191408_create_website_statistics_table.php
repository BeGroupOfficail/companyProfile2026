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
        // Create website_statistics table
        Schema::create('website_statistics', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_image')->nullable();
            $table->integer('count')->default(0);
            $table->enum('status', ['published', 'inactive']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_statistics');
    }
};
