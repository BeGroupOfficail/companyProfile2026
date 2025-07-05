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
            $table->mediumText('google_map')->nullable();

            // Mail settings
            $table->string('mail_host', 100)->nullable();
            $table->integer('mail_port', false, true)->nullable();
            $table->string('mail_from_address', 100)->nullable();
            $table->string('mail_from_name', 100)->nullable();
            $table->string('mail_encryption', 10)->nullable();
            $table->string('mail_username', 100)->nullable();
            $table->string('mail_password', 100)->nullable();

            // Social media
            $table->text('facebook_address')->nullable();
            $table->text('twitter_address')->nullable();
            $table->text('threads_address')->nullable();
            $table->text('youtube_address')->nullable();
            $table->text('instagram_address')->nullable();
            $table->text('pinterest_address')->nullable();
            $table->text('linkedin_address')->nullable();
            $table->text('tumblr_address')->nullable();
            $table->text('flickr_address')->nullable();

            // Captcha
            $table->string('nocaptcha_sitekey', 150)->nullable();
            $table->string('nocaptcha_secret', 150)->nullable();

            // Mailchimp
            $table->tinyText('mailchimp_api_key')->nullable();
            $table->tinyText('mailchimp_list_name')->nullable();
            $table->tinyText('mailchimp_list_id')->nullable();

            // Analytics
            $table->string('google_tag_manager_id',100)->nullable();
            $table->text('google_tag_manager_for_body')->nullable();
            $table->text('google_tag_manager_for_head')->nullable();

            $table->text('facebook_pixel_for_body')->nullable();
            $table->text('facebook_pixel_for_head')->nullable();

            $table->text('tiktok_pixel_for_body')->nullable();
            $table->text('tiktok_pixel_for_head')->nullable();

            $table->string('n_experience_years')->nullable();
            $table->string('n_awrds')->nullable();
            $table->string('n_tours')->nullable();
            $table->string('n_travelers')->nullable();


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
