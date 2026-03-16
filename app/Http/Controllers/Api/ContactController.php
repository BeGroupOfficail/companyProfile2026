<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\ContactUsRequest;
use App\Models\Dashboard\ContactUs\ContactUs;
use App\Factories\MessageSender\MessageSenderFactory;
use Exception;
use Illuminate\Support\Facades\Log;

use function App\Helper\apiResponse;

class ContactController extends Controller
{
    public function store(ContactUsRequest $request)
    {
        try {

            $validated = $request->validated();

            $contact = ContactUs::create($validated);

            $user = [
                'email'         => 'info@vrfegypt.com',
                'contact_email' => $contact->email,
                'name'          => $contact->name,
                'phone'         => $contact->phone,
                'message'       => $contact->message,
            ];

            $emailSender = MessageSenderFactory::make('email');

            $emailSender->send(
                [$user],
                'contact_us',
                __('home.Thank You'),
                __('home.Thank you for contact us we will call you soon')
            );

            return apiResponse(
                201,
                null,
                __('home.Thank you for contacting us. A customer service officer will contact you soon')
            );

        } catch (Exception $e) {

            Log::error($e->getMessage());

            return apiResponse(
                500,
                null,
                'Something went wrong'
            );
        }
    }
}
