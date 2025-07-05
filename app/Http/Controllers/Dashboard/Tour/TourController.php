<?php

namespace App\Http\Controllers\Dashboard\Tour;

use App\DataTables\Destination\DestinationDataTable;
use App\DataTables\Tour\TourDataTable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Destination\DestinationRequest;
use App\Http\Requests\Dashboard\Tour\TourRequest;
use App\Models\Dashboard\Tour\Tour;
use App\Services\Dashboard\Tour\TourService;
use Illuminate\Http\Request;

class TourController extends Controller
{
    protected $tourService;

    public function __construct(TourService $tourService)
    {
        $this->tourService = $tourService;

        $this->middleware('can:tours.read')->only('index');
        $this->middleware('can:tours.create')->only('store');
        $this->middleware('can:tours.update')->only('update');
        $this->middleware('can:tours.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(TourDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Tours.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        [$destinations,$tourTypes] = $this->tourService->create();
        return view('Dashboard.Tours.create', compact('destinations','tourTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TourRequest $request)
    {
        try {
            $dataValidated = $request->validated();

            $this->tourService->store($dataValidated);

            return redirect()->route('tours.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
    public function edit(Tour $tour)
    {
        [$destinations,$tourTypes] = $this->tourService->edit();

        return view('Dashboard.Tours.edit', compact('destinations','tour','tourTypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TourRequest $request, Tour $tour)
    {
        try {
            $dataValidated = $request->validated();

            $this->tourService->update($request, $dataValidated, $tour);

            return redirect()->route('tours.index')->with(['success' => __('messages.your_item_added_successfully')]);
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
            'selectedIds.*' => ['exists:tours,id']
        ]);

        $deleted = $this->tourService->deleteTours($selectedIds);

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
