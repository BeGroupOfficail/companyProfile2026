<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            // Site Information
            'site_name' => null,
            'site_desc' => null,
            'primary_color' => null,
            'secondary_color' => null,
            'logo' => null,
            'dark_logo' => null,
            'white_logo' => null,
            'alt_white_logo' => null,
            'alt_dark_logo' => null,
            'alt_logo' => null,

            // Contact Information
            'phone1' => null,
            'phone2' => null,
            'telephone' => null,
            'contact_email' => null,
            'support_email' => null,
            'fax' => null,
            'address1' => null,
            'address2' => null,
            'google_map' => null,

            // Mail Settings
            'mail_host' => null,
            'mail_port' => null,
            'mail_from_address' => null,
            'mail_from_name' => null,
            'mail_encryption' => null,
            'mail_username' => null,
            'mail_password' => null,

            // Social Media Links
            'facebook_address' => null,
            'twitter_address' => null,
            'threads_address' => null,
            'youtube_address' => null,
            'instagram_address' => null,
            'pinterest_address' => null,
            'linkedin_address' => null,
            'tumblr_address' => null,
            'flickr_address' => null,

            // Captcha
            'nocaptcha_sitekey' => null,
            'nocaptcha_secret' => null,

            // Mailchimp
            'mailchimp_api_key' => null,
            'mailchimp_list_name' => null,
            'mailchimp_list_id' => null,

            // Analytics & Pixels
            'google_tag_manager_id' => null,
            'google_tag_manager_for_body' => null,
            'google_tag_manager_for_head' => null,
            'facebook_pixel_for_body' => null,
            'facebook_pixel_for_head' => null,
            'tiktok_pixel_for_body' => null,
            'tiktok_pixel_for_head' => null,

            'n_experience_years'=>null,
            'n_awrds'=>null,
            'n_tours'=>null,
            'n_travelers'=>null,

            // Timestamps
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
