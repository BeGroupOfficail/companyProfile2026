<?php

namespace App\Models\Dashboard\Setting;

use App\Traits\HandlesTranslationsAndMedia;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;
    use HandlesTranslationsAndMedia;

    protected $fillable = [
        'site_name',
        'site_desc',
        'primary_color',
        'secondary_color',
        'logo',
        'dark_logo',
        'white_logo',
        'fav_icon',
        'alt_white_logo',
        'alt_dark_logo',
        'alt_logo',
        'alt_fav_icon',
        'phone1',
        'phone2',
        'telephone',
        'contact_email',
        'support_email',
        'fax',
        'address1',
        'address2',
        'google_map',
        'certificate_code',
        'certificate_example',
        'alt_certificate_example',

        // Mail settings
        'mail_host',
        'mail_port',
        'mail_from_address',
        'mail_from_name',
        'mail_to_address',
        'mail_to_name',
        'mail_encryption',
        'mail_username',
        'mail_password',

        // Social media
        'facebook_address',
        'twitter_address',
        'threads_address',
        'youtube_address',
        'instagram_address',
        'pinterest_address',
        'linkedin_address',
        'tumblr_address',
        'flickr_address',

        // Captcha
        'nocaptcha_sitekey',
        'nocaptcha_secret',

        // Mailchimp
        'mailchimp_api_key',
        'mailchimp_list_name',
        'mailchimp_list_id',

        // Analytics
        'google_tag_manager_id',
        'google_tag_manager_for_body',
        'google_tag_manager_for_head',
        'facebook_pixel_for_body',
        'facebook_pixel_for_head',
        'tiktok_pixel_for_body',
        'tiktok_pixel_for_head',

        //stats numbers
        'n_experience_years',
        'n_tours',
        'n_travelers',
        'n_awrds',
    ];

    public $translatable = ['site_name','site_desc']; // translatable attributes

    protected static function booted(){
        static::saved(function () {
            Cache::forget('settings');
        });

        static::deleted(function () {
            Cache::forget('settings');
        });
    }

}
