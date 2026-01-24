<?php

namespace App\Http\Controllers\Dashboard\Testimonial;

use App\DataTables\Testimonial\TestimonialDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Testimonials\TestimonialRequest;
use App\Models\Dashboard\Testimonial\Testimonial;
use App\Services\Dashboard\Testimonial\TestimonialService;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    protected $testimonialService;

    public function __construct(TestimonialService $testimonialService)
    {
        $this->testimonialService = $testimonialService;

        $this->middleware('can:testimonials.read')->only('index');
        $this->middleware('can:testimonials.create')->only('store');
        $this->middleware('can:testimonials.update')->only('update');
        $this->middleware('can:testimonials.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(TestimonialDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Testimonials.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Dashboard.Testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestimonialRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->testimonialService->store($dataValidated);

            return redirect()->route('testimonials.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        return view('Dashboard.Testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        try {
            $dataValidated = $request->validated();

            $this->testimonialService->update($request, $dataValidated, $testimonial);

            return redirect()->route('testimonials.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>$e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $selectedIds = $request->input('selectedIds');

        $request->validate([
            'selectedIds' => ['array', 'min:1'],
            'selectedIds.*' => ['exists:testimonials,id']
        ]);

        $deleted = $this->testimonialService->deleteTestimonials($selectedIds);

        if (request()->ajax()) {
            if (!$deleted) {
                return response()->json(['message' => $deleted ?? __('messages.an messages.error entering data')], 422);
            }
            return response()->json(['success' => true, 'message' => trans('messages.your_items_deleted_successfully')]);
        }
        if (!$deleted) {
            return redirect()->back()->withErrors($delete ?? __('messages.an error has occurred. Please contact the developer to resolve the issue'));
        }
    }

}
