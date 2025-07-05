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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->json('short_desc')->nullable();
            $table->json('long_desc')->nullable();
            $table->json('tour_plan')->nullable();
            $table->string('tour_type')->nullable();
            $table->string('image')->nullable();
            $table->string('alt_image')->nullable();
            $table->unsignedBigInteger('destination_id');
            $table->foreign('destination_id')->references('id')->on('destinations')->onDelete('cascade');
            $table->integer('person_price_per_day')->nullable();
            $table->integer('number_days')->nullable();
            $table->integer('number_nights')->nullable();
            $table->enum('status', ['published', 'inactive'])->default('published');
            $table->boolean('home')->default(1);
            $table->boolean('menu')->default(1);
            $table->boolean('featured')->default(1);


            $table->json('slug')->nullable();
            $table->json('meta_title',255)->nullable();
            $table->json('meta_desc')->nullable();
            $table->boolean('index')->nullable()->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('destination_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
