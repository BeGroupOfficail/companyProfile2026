<?php

namespace App\Factories\MessageSender;

interface MessageSenderInterface
{
    public function send(array $contacts,string $blade ,string $title ,string $emailContent):int;
}
