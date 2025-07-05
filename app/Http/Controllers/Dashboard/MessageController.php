<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\MessageDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Trainings\SendMessageRequest;
use App\Jobs\SendEmails;
use App\Jobs\SendSms;
use App\Jobs\SendWhatsapp;
use App\Models\Dashboard\Message;
use App\Models\Dashboard\Training;
use App\Services\Dashboard\Message\MessageService;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use function PHPUnit\Framework\throwException;

class MessageController extends Controller
{
protected $messageService;

    public function __construct(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    public function index(MessageDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Messages.index');
    }

    public function create()
    {
        [$trainings, $types]= $this->messageService->create();
        return view('Dashboard.Messages.create', compact('trainings', 'types'));
    }

    public function sendMessage(SendMessageRequest $request)
    {
        $training = Training::with('students')->where('id', $request->training_id)->first();
        $subject = $request->subject;
        $message = $request->message;
        $contacts = $training->students;
        if ($contacts->isEmpty()) {
            return back()->with('error', 'No contacts found for this training.');
        }
        try {
            $this->messageService->send($request, $subject,$message, $contacts );
            return redirect()->route('messages.index')->with('success', 'Message dispatched successfully.');
        } catch (\Exception $e) {
            redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }




}
