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
        Schema::create('company_seo', function (Blueprint $table) {
            $table->id();

            // meta tags
            $table->json('title')->nullable();
            $table->json('author')->nullable();
            $table->json('description')->nullable();
            $table->json('canonical')->nullable();
            $table->string('robots')->default('index,follow');
            $table->string('content_type')->default('text/html');

            // structured seo sections
            $table->json('open_graph')->nullable();
            $table->json('twitter_card')->nullable();
            $table->json('hreflang_tags')->nullable();
            $table->json('schema')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_seo');
    }
};
