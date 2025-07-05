<?php

namespace App\Services\Dashboard\Message;

use App\Models\Dashboard\Country;
use App\Models\Dashboard\Area;
use App\Models\Dashboard\Message;
use App\Models\Dashboard\Region;
use App\Models\Dashboard\Training;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class MessageService
{
    public function create()
    {
        $currentLang = App::getLocale();
        $trainings = Training::get()->mapWithKeys(function ($training) use ($currentLang) {
            return [$training->id => $training->course->getTranslation('name', $currentLang) . ' - ' . $training->code];
        })->toArray();

        $types = Message::getTypes();
        
        return [$trainings, $types];
    }

    public function send($request, $subject,$message, $contacts)
    {
        DB::beginTransaction();
        try {
            $messageRecord = Message::create([
                'training_id' => $request->training_id,
                'type' => $request->type,
                'n_sent' => 0,
                'n_failed' => 0,
                'n_delivered' => 0,
            ]);
            $n_sent = 0;
            switch ($request->type) {
                case 'sms':
                    $n_sent = $this->sendSMSMessages($contacts, $subject, $message);
                    break;
                case 'whatsapp':
                    $n_sent = $this->sendWhatsappMessages($contacts, $subject, $message);
                    break;
                case 'email':
                    $n_sent = $this->sendEmails($contacts, $subject, $message);
                    break;
                default:
                    throw new \Exception("Unsupported type: " . $request->type);
            }
            $messageRecord->update(['n_sent' => $n_sent]);
            DB::commit();
            return $messageRecord;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
    
    public function sendEmails($contacts, $subject, $message)
    {
        try {
            $emails = $contacts->pluck('email')->filter()->unique()->toArray();
            $chunks = array_chunk($emails, 50);
            // foreach ($chunks as $chunk) {
            //     dispatch(new SendEmails($chunk, $message, $subject))->delay(now()->addSeconds(5));
            // }
            return count($emails );
        } catch (\Exception $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public function sendSMSMessages($contacts, $subject, $message)
    {
        try {
            $phones = $contacts->pluck('phone')->filter()->unique()->toArray();
            $chunks = array_chunk($phones, 50);
            // foreach ($chunks as $chunk) {
            //     dispatch(new SendSms($chunk, $message, $subject))->delay(Carbon::now()->addSeconds(5));
            // }
            return count($phones );
        } catch (\Exception $e) {
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

    public function sendWhatsappMessages($contacts, $subject, $message)
    {
        try{
            $phones = $contacts->pluck('phone')->filter()->unique()->toArray();
            $chunks = array_chunk($phones, 50);
            // foreach ($chunks as $chunk) {
            //     dispatch(new SendWhatsapp($chunk, $message, $subject))->delay(Carbon::now()->addSeconds(5));
            // }
            return count($phones );
        }
        catch( \Exception $e){
            throw new \Exception('Error: ' . $e->getMessage());
        }
    }

}
