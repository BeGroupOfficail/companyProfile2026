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
        Schema::table('projects', function (Blueprint $table) {
            $table->json('type')->nullable()->after('alt_image');
            $table->json('location')->nullable()->after('type');
            $table->json('area')->nullable()->after('location');
            $table->json('client')->nullable()->after('area');
            $table->json('badges')->nullable()->after('client');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['type','location','area','client','badges']);
        });
    }
};
