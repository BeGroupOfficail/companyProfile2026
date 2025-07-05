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
        Schema::create('temp_upload_files', function (Blueprint $table) {
            $table->id();
            $table->string('original_name')->nulaable();
            $table->string('server_name')->nulaable();
            $table->string('type')->nulaable(); // e.g., 'page', 'category', 'custom'
            $table->unsignedBigInteger('type_value_id')->nullable(); // ID of linked item
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('temp_uploads');
    }
};
