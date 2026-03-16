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
        Schema::create('company_sub_sections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('section_id')
                ->constrained('company_sections')
                ->cascadeOnDelete();

            $table->json('title')->nullable();

            $table->json('description')->nullable();

            $table->enum('layout', [
                'title_only',
                'title_desc'
            ])->default('title_desc');

            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['section_id','sort_order']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_sub_sections');
    }
};
