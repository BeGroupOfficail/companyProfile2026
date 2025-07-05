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
        Schema::table('faqs', function (Blueprint $table) {

            if (Schema::hasIndex('faqs', 'faqs_type_value_id_index')) {
                $table->dropIndex('faqs_type_value_id_index');
            }

            // Drop the columns
            $table->dropColumn(['types', 'type_value_id']);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->string('types')->nullable(); // Adjust the column type as needed
            $table->unsignedBigInteger('type_value_id')->nullable(); // Adjust as needed
            $table->index('type_value_id', 'faqs_type_value_id_index'); // Adjust index name as needed
        });
    }
};
