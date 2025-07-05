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
        // Check if the old table exists before renaming
        if (Schema::hasTable('menu-items')) {
            Schema::rename('menu-items', 'menu_items');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverse the renaming
        if (Schema::hasTable('menu_items')) {
            Schema::rename('menu_items', 'menu-items');
        }
    }
};
