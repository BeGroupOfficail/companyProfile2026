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
        Schema::table('company_sub_sections', function (Blueprint $table) {

            //  drop foreign key
            $table->dropForeign(['section_id']);

            //  nullable
            $table->foreignId('section_id')->nullable()->change();

            //  foreign key
            $table->foreign('section_id')
                ->references('id')
                ->on('company_sections')
                ->cascadeOnDelete();

            //  key unique
            $table->string('key')->unique()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('company_sub_sections', function (Blueprint $table) {

            //  drop key
            $table->dropUnique(['key']);
            $table->dropColumn('key');

            //  drop foreign key
            $table->dropForeign(['section_id']);

            //  column
            $table->foreignId('section_id')->nullable(false)->change();

            //  foreign key
            $table->foreign('section_id')
                ->references('id')
                ->on('company_sections')
                ->cascadeOnDelete();
        });
    }
};
