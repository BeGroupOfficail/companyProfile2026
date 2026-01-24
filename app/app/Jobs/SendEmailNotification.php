<?php
// app/Jobs/SendEmailNotification.php

namespace App\Jobs;

use App\Models\Dashboard\Setting\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class SendEmailNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $contacts;
    protected string $blade;
    protected string $title;
    protected string $emailContent;
    protected string $originalLocale;

    public function __construct(array $contacts, string $blade, string $title, string $emailContent)
    {
        $this->contacts = $contacts;
        $this->blade = $blade;
        $this->title = $title;
        $this->emailContent = $emailContent;
        $this->originalLocale = app()->getLocale();
    }

    public function handle()
    {
        $users = $this->contacts;
        $inint_count = 0;
        $setting = Setting::first();
        foreach ($users as $user) {
            if (!empty($user['email'])) {
                $userLocale = $user->locale ?? $this->originalLocale;
                App::setLocale($userLocale);
                View::addNamespace('emails', resource_path('views/websit/emails/'));
                Mail::send(
                    'emails::' . $this->blade,
                    [
                        'user' => $user,
                        'setting'=>$setting,
                        'emailContent' => $this->emailContent,
                    ],
                    function ($mail) use ($user) {
                        $mail->to($user['email'])->subject(__($this->title));
                    },
                );
                $inint_count++;
            }
        }
        App::setLocale($this->originalLocale);
        return $inint_count;
    }
}
