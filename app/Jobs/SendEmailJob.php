<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    public $timeout = 120;
    public $backoff = [30, 60, 120]; // Retry delays in seconds

    protected string $email;
    protected string $bladeName;
    protected array $params;

    /**
     * Create a new job instance.
     */
    public function __construct(string $email, string $bladeName, array $params = [])
    {
        $this->email = $email;
        $this->bladeName = $bladeName;
        $this->params = $params;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::send("emails.{$this->bladeName}", $this->params, function ($message) {
                $message->to($this->email);
                
                // Set subject if provided in params
                if (isset($this->params['subject'])) {
                    $message->subject($this->params['subject']);
                }
                
                // Set from if provided in params
                if (isset($this->params['from'])) {
                    $message->from($this->params['from']);
                } else {
                    // Use default from config
                    $message->from(config('mail.from.address'), config('mail.from.name'));
                }
                
                // Set reply-to if provided
                if (isset($this->params['reply_to'])) {
                    $message->replyTo($this->params['reply_to']);
                }
                
                // Set CC if provided
                if (isset($this->params['cc'])) {
                    $message->cc($this->params['cc']);
                }
                
                // Set BCC if provided
                if (isset($this->params['bcc'])) {
                    $message->bcc($this->params['bcc']);
                }
                
                // Add attachments if provided
                if (isset($this->params['attachments']) && is_array($this->params['attachments'])) {
                    foreach ($this->params['attachments'] as $attachment) {
                        if (is_string($attachment)) {
                            $message->attach($attachment);
                        } elseif (is_array($attachment)) {
                            $message->attach(
                                $attachment['path'],
                                $attachment['options'] ?? []
                            );
                        }
                    }
                }
            });
            
        } catch (\Exception $e) {
            throw $e; // Re-throw to trigger retry mechanism
        }
    }

    /**
     * Handle job failure
     */
    public function failed(\Throwable $exception): void
    {
        // Log::error('Email job failed permanently', [
        //     'email' => $this->email,
        //     'blade' => $this->bladeName,
        //     'error' => $exception->getMessage(),
        //     'attempts' => $this->attempts()
        // ]);
    }
}