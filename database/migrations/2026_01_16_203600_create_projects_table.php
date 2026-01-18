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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->json('short_desc')->nullable();
            $table->json('long_desc')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_image')->nullable();
            $table->json('slug')->nullable();
            $table->enum('status', ['published', 'inactive'])->default('published');
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->boolean('home')->default(1);
            $table->boolean('menu')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
