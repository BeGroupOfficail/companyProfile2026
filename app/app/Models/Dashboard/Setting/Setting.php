<?php

namespace App\Models\Dashboard\Setting;

use App\Traits\HandlesTranslationsAndMedia;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Spatie\Translatable\HasTranslations;

class Setting extends Model
{
    use HasTranslations;
    use HandlesTranslationsAndMedia;

     const SMSPROVIDERS= [
        'Msegat'=>'Msegat',
        'Jawaly'=>'Jawaly',
    ];

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
        'phone3',
        'side_phone',
        'side_whatsapp',
        'telephone',
        'contact_email',
        'support_email',
        'fax',
        'address1',
        'address2',
        'address_en_1',
        'address_en_2',
        'google_map',

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

        //sms settings
        'sms_sender_name',
        'sms_app_id',
        'sms_app_sec',
        'sms_provider',
        'sms_user_name',

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
        'tiktok_address',
        'snapchat_address',
        'whatsapp_address',

    ];

    public $translatable = ['site_name','site_desc'];

    protected static function booted(){
        static::saved(function () {
            Cache::forget('settings');
        });

        static::deleted(function () {
            Cache::forget('settings');
        });
    }
}
