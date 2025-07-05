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
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'home')) {
                $table->boolean('home')->default(false)->after('status');
            }

            if (!Schema::hasColumn('categories', 'menu')) {
                $table->boolean('menu')->default(false)->after('home');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'home')) {
                $table->dropColumn('home');
            }

            if (Schema::hasColumn('categories', 'menu')) {
                $table->dropColumn('menu');
            }
        });
    }
};
