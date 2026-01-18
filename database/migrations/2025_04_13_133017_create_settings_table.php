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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->json('site_name', 100)->nullable();
            $table->json('site_desc')->nullable();
            $table->string('logo', 100)->nullable();
            $table->string('dark_logo', 100)->nullable();
            $table->string('white_logo', 100)->nullable();
            $table->string('alt_white_logo', 100)->nullable();
            $table->string('alt_dark_logo', 100)->nullable();
            $table->string('alt_logo', 100)->nullable();
            $table->string('phone1', 20)->nullable();
            $table->string('phone2', 20)->nullable();
            $table->string('telephone', 20)->nullable();
            $table->string('contact_email', 150)->nullable();
            $table->string('support_email', 150)->nullable();
            $table->string('fax', 20)->nullable();
            $table->string('address1', 250)->nullable();
            $table->string('address2', 250)->nullable();
            $table->string('address_en_1', 250)->nullable();
            $table->string('address_en_2', 250)->nullable();
            $table->mediumText('google_map')->nullable();

            // Mail settings
            $table->string('mail_host', 100)->nullable();
            $table->integer('mail_port', false, true)->nullable();
            $table->string('mail_from_address', 100)->nullable();
            $table->string('mail_from_name', 100)->nullable();
            $table->string('mail_encryption', 10)->nullable();
            $table->string('mail_username', 100)->nullable();
            $table->string('mail_password', 100)->nullable();

            //sms settings//
            $table->string('sms_sender_name')->nullable();
            $table->string('sms_app_id')->nullable();
            $table->string('sms_app_sec')->nullable();
            $table->string('sms_provider')->nullable();
            $table->string('sms_user_name')->nullable();

            // Social media
            $table->text('facebook_address')->nullable();
            $table->text('twitter_address')->nullable();
            $table->text('threads_address')->nullable();
            $table->text('youtube_address')->nullable();
            $table->text('tiktok_address')->nullable();
            $table->text('instagram_address')->nullable();
            $table->text('pinterest_address')->nullable();
            $table->text('linkedin_address')->nullable();
            $table->text('tumblr_address')->nullable();
            $table->text('flickr_address')->nullable();
            $table->text('whatsapp_address')->nullable();
            $table->text('snapchat_address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
