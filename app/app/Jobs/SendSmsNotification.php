<?php
namespace App\Jobs;
use App\Models\Dashboard\Setting\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use function PHPUnit\Framework\throwException;

class SendSmsNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $contacts;
    protected string $smsContent;
    protected string $user_name;
    protected string $senderName;
    protected string $sms_provider;

    protected string $appId;

    protected string $appSecret;

    public function __construct(array $contacts, string $smsContent)
    {
        $this->contacts = $contacts;
        $this->smsContent = $smsContent;
        $setting = Setting::first();
        $this->sms_provider = $setting->sms_provider ?? '-';
        $this->user_name = $setting->sms_user_name ?? '-';
        $this->senderName = $setting->sms_sender_name ?? '-';
        $this->appId = $setting->sms_app_id ?? '-';
        $this->appSecret = $setting->sms_app_sec ?? '-';
    }

    public function handle(): void
    {
        $users = $this->contacts;
        foreach ($users as $user) {
            if ($user['phone']) {
                $phone = $user['phone'];
                $edit_phone = $this->normalizeSaudiPhone($phone);
                Log::info("started to send SMS to {$edit_phone} ");
                try {
                    switch ($this->sms_provider) {
                        case 'Msegat':
                            $this->sendMsegatMessage( $edit_phone, $this->smsContent);
                            break;
                        case 'Jawaly':
                            $this->sendJawalyMessage( $edit_phone, $this->smsContent);
                            break;
                        default:
                            throwException('Invalid SMS provider');
                            break;
                    }
                } catch (\Exception $e) {
                    Log::info("Failed to send SMS to {$edit_phone}: " . $e->getMessage());
                }
            }
        }
    }

    ///4jwaly intigrtion method///
    protected function sendJawalyMessage($phone, $smsContent)
    {
        $app_hash = base64_encode("{$this->appId}:{$this->appSecret}");

        $messages = [
            'messages' => [
                [
                    'text' => $smsContent,
                    'numbers' => [$phone],
                    'sender' => $this->senderName,
                ],
            ],
        ];

        $url = 'https://api-sms.4jawaly.com/api/v1/account/area/sms/send';
        $headers = ['Accept: application/json', 'Content-Type: application/json', "Authorization: Basic {$app_hash}"];

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($messages));
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
    }

    ///msegat intigrtion method///
    protected function sendMsegatMessage($phone, $smsContent)
    {
        $url = 'https://www.msegat.com/gw/sendsms.php';

        $data = [
            'userName' => $this->user_name,
            'apiKey' => $this->appId,
            'numbers' => $phone,
            'userSender' => $this->senderName,
            'msg' => $smsContent,
            'msgEncoding' => 'UTF8',
        ];

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($url, $data);

        Log::info('Msegat API Response:', [
            'status' => $response->status(),
            'body' => $response->body(),
            'data'=>$data
        ]);

        if ($response->successful()) {
            Log::info("Msegat SMS sent successfully to {$phone}");
        } else {
            Log::error("Failed to send Msegat SMS to {$phone}");
        }
    }

    function normalizeSaudiPhone($phone)
    {
        $phone = preg_replace('/\D+/', '', $phone);
        if (str_starts_with($phone, '966')) {
            $phone = substr($phone, 3);
        }

        $phone = ltrim($phone, '0');
        return '966' . $phone;
    }
}
