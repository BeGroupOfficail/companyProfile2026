<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsapp implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phoneNumbers;
    protected $message;
    protected $subject;

    /**
     * Create a new job instance.
     */
     public function __construct($phoneNumbers, string $message,$subject)
    {
        $this->phoneNumbers = $phoneNumbers;
        $this->message = $message;
        $this->subject = $subject;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
          $curl = curl_init();
          curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.taqnyat.sa/wa/v2/messages/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
              "to": "'.$this->phoneNumbers.'",
              "type": "text",
              "text": {
                "title": "'.$this->subject.'"
                "body": "'.$this->message.'"
              }
        }',
          CURLOPT_HTTPHEADER => array(
            'Authorization: ee40695d05f96c0c5fb416fac70cf68d',
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
    }
}
