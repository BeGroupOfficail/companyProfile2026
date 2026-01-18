<?php

namespace App\Http\Requests\Dashboard\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Site Information
            'site_name_en' => 'nullable|string|max:100',
            'site_name_ar' => 'nullable|string|max:100',
            'secondary_color'=>'nullable|regex:/^#([A-Fa-f0-9]{6})$/',
            'primary_color'=>'nullable|regex:/^#([A-Fa-f0-9]{6})$/',
            'site_desc_en' => 'nullable|string',
            'site_desc_ar' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'dark_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'white_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'fav_icon' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5000',
            'alt_logo' => 'nullable|string|max:100',
            'alt_white_logo' => 'nullable|string|max:100',
            'alt_dark_logo' => 'nullable|string|max:100',
            'alt_fav_icon' => 'nullable|string|max:100',

            // Contact Information
            'phone1' => 'nullable|numeric',
            'phone2' => 'nullable|numeric',
            'telephone' => 'nullable|numeric',
            'contact_email' => 'nullable|email',
            'support_email' => 'nullable|email',
            'fax' => 'nullable|numeric  ',
            'address1' => 'nullable|string|max:250',
            'address2' => 'nullable|string|max:250',
            'address_en_1' => 'nullable|string|max:250',
            'address_en_2' => 'nullable|string|max:250',
            'google_map' => 'nullable|string',

            // Mail Settings
            'mail_host' => 'nullable|string|max:100',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_from_address' => 'nullable|email|max:100',
            'mail_from_name' => 'nullable|string|max:100',
            'mail_encryption' => 'nullable|string|max:10|in:tls,ssl,starttls,smtp',
            'mail_username' => 'nullable|string|max:100',
            'mail_password' => 'nullable|string|max:100',

            //Sms Settings
            'sms_sender_name' => 'nullable|string|max:100',
            'sms_app_id' => 'nullable|string|max:100',
            'sms_app_sec' => 'nullable|string|max:100',
            'sms_provider' => 'nullable|string|max:100',
            'sms_user_name' => 'nullable|string|max:100',

            // Social Media Links
            'facebook_address' => 'nullable|url',
            'twitter_address' => 'nullable|url',
            'threads_address' => 'nullable|url',
            'youtube_address' => 'nullable|url',
            'instagram_address' => 'nullable|url',
            'pinterest_address' => 'nullable|url',
            'linkedin_address' => 'nullable|url',
            'tumblr_address' => 'nullable|url',
            'flickr_address' => 'nullable|url',
            'tiktok_address' => 'nullable|url',
            'snapchat_address' => 'nullable|url',
            'whatsapp_address' => 'nullable|url',
            'working_hours'=> 'nullable|string',
            'postal_code'=> 'nullable|string',
        ];



    }
}
