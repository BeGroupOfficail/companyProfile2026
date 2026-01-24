<?php
/** * Usage example:
    $sender = MessageSenderFactory::make('email');
    $sender->send([1,2,3,4],'mailBlade','Welcome title', 'Welcome message from Ramzy');

    $smsSender = MessageSenderFactory::make('sms');
    $smsSender->send([1,2,3,4],'smsBlade','Welcome title', 'Welcome message from Ramzy');
 */

namespace App\Factories\MessageSender;

use InvalidArgumentException;

class MessageSenderFactory
{
    public static function make(string $type): MessageSenderInterface
    {
        return match ($type) {
            'email' => new EmailSender(),
            'sms' => new SmsSender(),
            default => throw new InvalidArgumentException("Unsupported message type [$type]"),
        };
    }
}
