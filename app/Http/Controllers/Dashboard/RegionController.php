<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\RegionDataTable;
use App\Models\Dashboard\Region;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\RegionRequest;
use App\Services\Dashboard\RegionService;
use Illuminate\Http\Request;

class RegionController extends Controller
{

    protected $regionService;

    public function __construct(RegionService $regionService)
    {
        $this->regionService = $regionService;

        $this->middleware('can:regions.read')->only('index');
        $this->middleware('can:regions.create')->only('store');
        $this->middleware('can:regions.update')->only('update');
        $this->middleware('can:regions.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(RegionDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Regions.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = $this->regionService->create();
        return view('Dashboard.Regions.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RegionRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->regionService->store($dataValidated);
            return redirect()->route('settings.regions.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Region $region)
    {
        $countries = $this->regionService->create();
        return view('Dashboard.Regions.edit', compact('region', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RegionRequest $request, Region $region)
    {
        try {
            $dataValidated = $request->validated();
            $this->regionService->update($dataValidated, $region);
            return redirect()->route('settings.regions.index')->with(['success' => __('messages.your_item_updated_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
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
            'selectedIds.*' => ['exists:regions,id']
        ]);
        $deleted = $this->regionService->delete($selectedIds);

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
