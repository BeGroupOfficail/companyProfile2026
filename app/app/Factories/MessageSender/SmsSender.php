<?php

namespace App\Factories\MessageSender;

use App\Jobs\SendSmsNotification;
use Illuminate\Support\Facades\Log;

class SmsSender implements MessageSenderInterface
{
    public function send(array $contacts,  $blade='', string $title, string $smsContent): int
    {

        $chunks = array_chunk($contacts, 10);
        $totalQueued = 0;
        foreach ($chunks as $chunk) {
            $count = count(array_filter($chunk, fn($user) => !empty($user['phone'])));
            $totalQueued += $count;

            SendSmsNotification::dispatch($chunk, $smsContent);
            //SendSmsNotification::dispatch($chunk, $smsContent)->delay(now()->addSeconds(20));
        }
        Log::info("Sending SMS sender");
        return $totalQueued;
    }
}
