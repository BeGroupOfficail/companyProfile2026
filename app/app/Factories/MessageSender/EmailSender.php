<?php

namespace App\Factories\MessageSender;

use App\Jobs\SendEmailNotification;

class EmailSender implements MessageSenderInterface
{
    public function send(array $contacts, string $blade,string $title, string $emailContent=''): int
    {
        $chunks = array_chunk($contacts, 10);
        
        $totalQueued = 0;
        
        foreach ($chunks as $chunk) {
            
            $count = count(array_filter($chunk, fn ($user) => !empty($user['email'])));
            $totalQueued += $count;
            SendEmailNotification::dispatch($chunk, $blade, $title, $emailContent);
        }
        return $totalQueued;
    }
}
