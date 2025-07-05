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
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'dark_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'white_logo' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'fav_icon' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'certificate_example' => 'nullable|image|mimes:jpeg,png,jpg|max:5000',

            'certificate_code' => 'nullable|string|max:100',
            'alt_logo' => 'nullable|string|max:100',
            'alt_white_logo' => 'nullable|string|max:100',
            'alt_dark_logo' => 'nullable|string|max:100',
            'alt_fav_icon' => 'nullable|string|max:100',
            'alt_certificate_example' => 'nullable|string|max:100',

            // Contact Information
            'phone1' => 'nullable|numeric',
            'phone2' => 'nullable|numeric',
            'telephone' => 'nullable|numeric',
            'contact_email' => 'nullable|email',
            'support_email' => 'nullable|email',
            'fax' => 'nullable|numeric  ',
            'address1' => 'nullable|string|max:250',
            'address2' => 'nullable|string|max:250',
            'google_map' => 'nullable|string',

            // Mail Settings
            'mail_host' => 'nullable|string|max:100',
            'mail_port' => 'nullable|integer|min:1|max:65535',
            'mail_from_address' => 'nullable|email|max:100',
            'mail_from_name' => 'nullable|string|max:100',
            'mail_encryption' => 'nullable|string|max:10|in:tls,ssl,starttls',
            'mail_username' => 'nullable|string|max:100',
            'mail_password' => 'nullable|string|max:100',

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

            // Captcha
            'nocaptcha_sitekey' => 'nullable|string|max:250',
            'nocaptcha_secret' => 'nullable|string|max:250',

            // Mailchimp
            'mailchimp_api_key' => 'nullable|string',
            'mailchimp_list_name' => 'nullable|string',
            'mailchimp_list_id' => 'nullable|string',

            // Analytics & Pixels
            'google_tag_manager_id' => 'nullable|string|max:250',
            'google_tag_manager_for_body' => 'nullable|string',
            'google_tag_manager_for_head' => 'nullable|string',
            'facebook_pixel_for_body' => 'nullable|string',
            'facebook_pixel_for_head' => 'nullable|string',
            'tiktok_pixel_for_body' => 'nullable|string',
            'tiktok_pixel_for_head' => 'nullable|string',

            //stats numbers
            'n_experience_years'=> 'nullable|integer',
            'n_tours'=> 'nullable|integer',
            'n_awrds'=> 'nullable|integer',
            'n_travelers'=> 'nullable|integer',
        ];
    }
}
