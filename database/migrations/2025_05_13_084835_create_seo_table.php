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
        Schema::create('seo', function (Blueprint $table) {
            $table->id();
            $table->string('page_type');
            $table->json('schema_types')->nullable();
            $table->json('title')->nullable();
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
        Schema::dropIfExists('seo');
    }
};
