<?php

namespace App\Http\Controllers\Dashboard\Faq;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Faqs\FaqRequest;
use App\Models\Dashboard\Faq\Faq;
use App\Services\Dashboard\Faq\FaqService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $faqService;

    public function __construct(FaqService $faqService)
    {
        $this->faqService = $faqService;

        $this->middleware('can:faqs.read')->only('index');
        $this->middleware('can:faqs.create')->only('store');
        $this->middleware('can:faqs.update')->only('update');
        $this->middleware('can:faqs.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(){
        $faqs = Faq::all();
        return view('Dashboard.Faqs.edit',compact('faqs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $faqs = Faq::all();

            $this->faqService->update($request, $faqs);

            return redirect()->route('faqs.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }
    }

}
