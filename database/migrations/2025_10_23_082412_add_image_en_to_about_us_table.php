<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->string('image_en')->nullable()->after('image'); // or adjust position
            $table->string('alt_image_en')->nullable()->after('image_en'); // or adjust position
            $table->string('banner_en')->nullable()->after('banner'); // or adjust position
            $table->string('alt_banner_en')->nullable()->after('banner_en'); // or adjust position
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_us', function (Blueprint $table) {
            $table->dropColumn('image_en','alt_image_en','banner_en','alt_banner_en');
        });
    }
};
