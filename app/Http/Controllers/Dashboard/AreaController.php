<?php

namespace App\Http\Controllers\Dashboard;

use App\DataTables\AreaDataTable;
use App\Models\Dashboard\Area;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Settings\AreaRequest;
use App\Models\Dashboard\Region;
use App\Services\Dashboard\AreaService;
use Illuminate\Http\Request;

class AreaController extends Controller
{

    protected $areaService;

    public function __construct(AreaService $areaService)
    {
        $this->areaService = $areaService;

        $this->middleware('can:areas.read')->only('index');
        $this->middleware('can:areas.create')->only('store');
        $this->middleware('can:areas.update')->only('update');
        $this->middleware('can:areas.delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AreaDataTable $dataTable)
    {
        return $dataTable->render('Dashboard.Areas.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = $this->areaService->create();
        return view('Dashboard.Areas.create', compact('countries'));
    }

    public function getCountryRegions(Request $request){
        $regions = Region::where('country_id', $request->country_id)->get(['id', 'name']);
        return response()->json($regions);
    }

    public function getRegionAreas(Request $request){
        $areas = Area::where('region_id', $request->region_id)->get(['id', 'name']);
        return response()->json($areas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AreaRequest $request)
    {
        try {
            $dataValidated = $request->validated();
            $this->areaService->store($dataValidated);
            return redirect()->route('settings.areas.index')->with(['success' => __('messages.your_item_added_successfully')]);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Area $area)
    {
        [$countries, $regions] = $this->areaService->edit($area);
        return view('Dashboard.Areas.edit', compact('area', 'countries','regions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AreaRequest $request, Area $area)
    {
        try {
            $dataValidated = $request->validated();
            $this->areaService->update($dataValidated, $area);
            return redirect()->route('settings.areas.index')->with(['success' => __('messages.your_item_updated_successfully')]);
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
            'selectedIds.*' => ['exists:areas,id']
        ]);
        $deleted = $this->areaService->delete($selectedIds);

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
