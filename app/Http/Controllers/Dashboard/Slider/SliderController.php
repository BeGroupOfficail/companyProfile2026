<?php

namespace App\Http\Controllers\Dashboard\Slider;

use App\DataTables\Slider\SliderDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Sliders\SliderRequest;
use App\Models\Dashboard\Slider\Slider;
use App\Services\Dashboard\Slider\SliderService;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    protected $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->sliderService = $sliderService;

        $this->middleware('can:sliders.read')->only('index');
        $this->middleware('can:sliders.create')->only('store');
        $this->middleware('can:sliders.update')->only('update');
        $this->middleware('can:sliders.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(SliderDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Sliders.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sliders = $this->sliderService->create();
        return view('Dashboard.Sliders.create', compact('sliders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->sliderService->store($dataValidated);

            return redirect()->route('sliders.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(Slider $slider)
    {
        $sliders = $this->sliderService->create();
        return view('Dashboard.Sliders.edit', compact('slider', 'sliders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SliderRequest $request, Slider $slider)
    {
        try {
            $dataValidated = $request->validated();

            $this->sliderService->update($request, $dataValidated, $slider);

            return redirect()->route('sliders.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:sliders,id']
        ]);

        $deleted = $this->sliderService->deleteSliders($selectedIds);

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
