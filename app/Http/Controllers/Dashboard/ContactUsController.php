<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Dashboard\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index(){
        $messages = ContactUs::paginate(20);
        return view('Dashboard.ContactUs.index',compact('messages'));
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
