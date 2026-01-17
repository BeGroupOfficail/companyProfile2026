<?php

namespace App\Http\Controllers\Dashboard\ContactUs;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\ContactUs\ContactUs;
use App\Models\Dashboard\Crm\CrmEmployee;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $messages_query = ContactUs::orderByDesc('id');
        if(isset($request->status) &&in_array($request->status,[0,1])){
            $messages_query =$messages_query->where('seen',$request->status);
        }
        $messages = $messages_query->get();
        $employees = CrmEmployee::with('user')->get()
            ->mapWithKeys(function ($employee) {
                return [$employee->id => $employee->user?->name];
            })->toArray();
        return view('Dashboard.ContactUs.index', compact('messages','employees'));
    }
    public function show(ContactUs $contactUs){
        $contactUs->update(['seen'=>1]);
        return back()->with('success',__('dash.your_item_updated_successfully'));
    }
    public function destroy(ContactUs $contactUs){
        $contactUs->delete();
        return response()->json(['success' => true, 'message' => trans('messages.your_items_deleted_successfully')]);
    }
}
