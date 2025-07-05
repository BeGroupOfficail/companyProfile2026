<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Mail;

class SendEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $emails;
    protected $message;
    protected $subject;

    /**
     * Create a new job instance.
     */
     public function __construct(array $emails, string $message, string $subject)
    {
        $this->emails = $emails;
        $this->subject = $subject;
        $this->message = $message;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = ['message' => $this->message];

        foreach($this->emails as $email){
            try {
                Mail::send('emails.trainingEmail', $data, function($msg) use($email) {
                    $msg->to($email, 'default')->subject($this->subject);
                    $msg->from(config('mail.from.address'), config('mail.from.name'));
                });
            } catch (\Exception $e) {
                \Log::error("Failed to send email to {$email}: " . $e->getMessage());
                continue;
            }
        }
    }
}