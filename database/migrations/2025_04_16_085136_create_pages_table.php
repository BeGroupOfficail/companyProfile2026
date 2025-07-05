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
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();;
            $table->json('short_desc')->nullable();
            $table->json('long_text')->nullable();
            $table->enum('status', ['published', 'inactive'])->default('inactive');
            $table->json('slug')->nullable();
            $table->json('meta_title')->nullable();
            $table->json('meta_desc')->nullable();
            $table->boolean('index')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pages');
    }
};
