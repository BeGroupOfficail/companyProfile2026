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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->json('question'); // Multilingual question
            $table->json('answer');   // Multilingual answer
            $table->string('lang', 10); // Language code (en, ar, etc.)
            $table->string('types');    // FAQ type/category
            $table->unsignedBigInteger('type_value_id')->nullable(); // Related entity ID
            $table->enum('status', ['published', 'inactive'])->default('inactive');
            $table->timestamps();
            $table->softDeletes();

            $table->index('lang');
            $table->index('types');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};
