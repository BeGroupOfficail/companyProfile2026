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
        // Create website_statistics table
        Schema::create('website_statistics', function (Blueprint $table) {
            $table->id();
            $table->json('title')->nullable();
            $table->integer('count')->default(0);
            $table->enum('status', ['published', 'inactive']);
            $table->timestamps();
            $table->softDeletes();
        });

        // Drop n_students column from settings table
        if (Schema::hasColumns('settings', ['n_students','n_instructors','n_courses','n_users','n_trainings','n_training_hours','n_centers','n_parteners'])) {
            Schema::table('settings', function (Blueprint $table) {
                $table->dropColumn('n_students');
                $table->dropColumn('n_instructors');
                $table->dropColumn('n_courses');
                $table->dropColumn('n_users');
                $table->dropColumn('n_trainings');
                $table->dropColumn('n_training_hours');
                $table->dropColumn('n_centers');
                $table->dropColumn('n_parteners');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop website_statistics table
        Schema::dropIfExists('website_statistics');

        // Restore n_students column to settings table
        Schema::table('settings', function (Blueprint $table) {
            $table->string('n_students')->nullable()->after('tiktok_pixel_for_head');
            $table->string('n_instructors')->nullable()->after('n_students');
            $table->string('n_courses')->nullable()->after('n_instructors');
            $table->string('n_users')->nullable()->after('n_courses');
            $table->string('n_trainings')->nullable()->after('n_users');
            $table->string('n_training_hours')->nullable()->after('n_trainings');
            $table->string('n_centers')->nullable()->after('n_training_hours');
            $table->string('n_parteners')->nullable()->after('n_centers');        
        });
    }
};
