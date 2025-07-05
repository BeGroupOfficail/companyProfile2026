<?php

namespace App\Providers;

use App\Models\Dashboard\Setting\Setting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config; 


class MailConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        try {
            // Cache settings to avoid repeated database queries
            $settings = cache()->remember('settings', 3600, function () {
                return Setting::firstOrfail();
            });

            // Set mail configuration dynamically
            Config::set('mail.mailers.smtp', [
                'transport' => $settings['mail_mailer'] ?? 'smtp',
                'host' => $settings['mail_host'] ?? 'smtp.gmail.com',
                'port' => $settings['mail_port'] ?? 587,
                'encryption' => $settings['mail_encryption'] ?? 'tls',
                'username' => $settings['mail_username'] ?? null,
                'password' => $settings['mail_password'] ?? null,
                'timeout' => null,
                'auth_mode' => null,
            ]);

            Config::set('mail.from', [
                'address' => $settings['mail_from_address'] ?? 'your-email@gmail.com',
                'name' => $settings['mail_from_name'] ?? config('app.name'),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load mail settings: ' . $e->getMessage());
        }
    }
}
